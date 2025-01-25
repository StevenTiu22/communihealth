<?php

namespace Tests\Feature;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Laravel\Fortify\Features;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected string $timestamp;

    protected function setUp(): void
    {
        parent::setUp();

        if (! Features::enabled(Features::emailVerification())) {
            $this->markTestSkipped('Email verification is not enabled.');
        }

        Event::fake();
        $this->user = User::factory()->unverified()->create();
        Carbon::setTestNow($this->timestamp = Carbon::now(config('app.timezone')));
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    private function tempVerificationUrl(int $id, string $email): string
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(config('auth.email-verification.expire', 30)),
            ['id' => $id, 'hash' => sha1($email)]
        );
    }

    private function expiredTempVerificationUrl(int $id, string $email): string
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            now()->subMinutes(config('auth.email-verification.expire', 30)),
            ['id' => $id, 'hash' => sha1($email)]
        );
    }

    public function test_email_verification_screen_can_be_rendered(): void
    {
        $response = $this->actingAs($this->user)->get('/email/verify');

        $response->assertStatus(200);
    }

    public function test_email_can_be_verified(): void
    {
        $verificationUrl = $this->tempVerificationUrl($this->user->id, $this->user->email);

        $response = $this->actingAs($this->user)->get($verificationUrl);

        Event::assertDispatched(Verified::class);

        $this->assertTrue($this->user->fresh()->hasVerifiedEmail());
        $response->assertRedirect(route('dashboard', absolute: false).'?verified=1');
    }

    public function test_email_can_not_verified_with_invalid_hash(): void
    {
        $verificationUrl = $this->tempVerificationUrl($this->user->id, 'wrong-email');

        $this->actingAs($this->user)->get($verificationUrl);

        $this->assertFalse($this->user->fresh()->hasVerifiedEmail());
    }

    public function test_email_verification_can_be_resent(): void
    {
        $response = $this->actingAs($this->user)->post('/email/send-verification');

        $response->assertStatus(302);

        Event::assertNotDispatched(Verified::class);
    }

    public function test_email_verification_link_can_be_used_within_a_timeframe(): void
    {
        $verificationUrl = $this->tempVerificationUrl($this->user->id, $this->user->email);

        $response = $this->actingAs($this->user)
            ->get($verificationUrl);

        Event::assertDispatched(Verified::class);

        $response->assertRedirect(config('fortify.home') . '?verified=1');
        $this->assertTrue($this->user->fresh()->hasVerifiedEmail());
    }

    public function test_email_verification_link_can_not_be_used_after_expiration(): void
    {
        $verificationUrl = $this->expiredTempVerificationUrl($this->user->id, $this->user->email);

        $response = $this->actingAs($this->user)->get($verificationUrl);
        $response->assertStatus(403);
        $this->assertFalse($this->user->fresh()->hasVerifiedEmail());
    }

    public function test_email_verification_resend_link_has_a_limited_attempts(): void
    {
        for ($i = 0; $i < config('auth.email-verification.resend_limit', 3); $i++) {
            $response = $this->actingAs($this->user)->post('/email/send-verification');
            $response->assertStatus(302)
                ->assertSessionHas('message', 'Verification link sent!');
        }

        $response = $this->actingAs($this->user)->post('/email/send-verification');
        $response->assertStatus(429);
    }
}
