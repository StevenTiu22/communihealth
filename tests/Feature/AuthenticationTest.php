<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
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

        $response = $this->post('/login', [
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

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/logout');

        $this->assertGuest();
    }

    // Email Verification
    public function test_email_verification_screen_can_be_rendered(): void
    {
        $response = $this->get('/email/verify');

        $response->assertStatus(200);
    }

    public function test_unverified_users_should_be_redirected_to_verify_email_screen(): void
    {
        $user = User::factory()->unverified()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $dashboardResponse = $this->get('/dashboard');
        $dashboardResponse->assertRedirect('/email/verify');

        $this->assertTrue(Auth::check());
        $this->assertEquals($user->id, Auth::id());
        $this->assertFalse(Auth::user()->hasVerifiedEmail());
    }

    /**
    public function test_verified_users_should_be_redirected_to_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');

        $this->assertTrue(Auth::check());
        $this->assertEquals($user->id, Auth::id());
        $this->assertTrue(Auth::user()->hasVerifiedEmail());
    }
     **/
    public function test_users_can_resend_email_verification_notification(): void
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->post('/email/verification-notification');

        $response->assertStatus(204);
    }

    public function test_users_can_only_resend_after_60_seconds(): void
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->post('/email/verification-notification');

        $response->assertStatus(204);

        $response = $this->actingAs($user)->post('/email/verification-notification');

        $response->assertStatus(429);
    }

    public function test_users_can_verify_email(): void
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get('/email/verify/' . $user->verification_token);

        $this->assertTrue(Auth::check());
        $this->assertEquals($user->id, Auth::id());
        $this->assertTrue(Auth::user()->hasVerifiedEmail());
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
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    public function test_users_can_logout_with_remember_me(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/logout');

        $this->assertGuest();
    }
}
