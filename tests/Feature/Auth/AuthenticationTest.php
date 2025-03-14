<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_not_authenticate_with_invalid_email(): void
    {
        User::factory()->create();

        $this->post('/login', [
            'email' => 'invalidemail@gmail.com',
            'password' => 'password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_not_authenticate_after_three_attempts(): void
    {
        $user = User::factory()->create();

        $response = null;

        for ($i = 0; $i < 3; $i++) {
            $response = $this->post('/login', [
                'email' => $user->email,
                'password' => 'wrong-password',
            ]);
            $response->assertStatus(302);
            $this->assertGuest();
        }

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(429);
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/logout');

        $this->assertGuest();
    }

    // Remember Me Function
    public function test_users_can_login_with_remember_me(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
            'remember' => 'on',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    public function test_users_can_login_without_remember_me(): void
    {
        $user = User::factory()->unremembered()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
            'remember' => null,
        ]);

        $rememberCookie = collect($response->headers->getCookies())
            ->filter(function ($cookie) {
                return str_starts_with($cookie->getName(), 'remember_web_');
            })->first();

        $this->assertNull($rememberCookie);
        $this->assertNull($user->fresh()->remember_token);
    }

    public function test_users_can_logout_with_remember_me(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/logout');

        $this->assertGuest();
    }

    public function test_successful_login_dispatches_login_event(): void
    {
        Event::fake();

        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        Event::assertDispatched(Login::class);
    }

    public function test_system_can_log_successful_login(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertDatabaseHas('activity_log', [
            'log_name' => 'Successful Login',
            'description' => "User {$user->username} has logged in.",
            'causer_id' => $user->id,
            'causer_type' => get_class($user),
        ]);
    }
}
