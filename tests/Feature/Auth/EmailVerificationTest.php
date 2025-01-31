<?php

namespace Tests\Feature\Auth;

use App\Listeners\LogVerification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Verified;
use Illuminate\Cache\RateLimiter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Laravel\Fortify\Features;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected string $timestamp;
    protected RateLimiter $rateLimiter;

    protected function setUp(): void
    {
        parent::setUp();

        if (! Features::enabled(Features::emailVerification())) {
            $this->markTestSkipped('Email verification is not enabled.');
        }

        Event::fake();

        $this->rateLimiter = app(RateLimiter::class);

        Carbon::setTestNow($this->timestamp = Carbon::now(config('app.timezone')));
    }

    protected function tearDown(): void
    {
        $this->rateLimiter->clear('verification');
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
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get('/email/verify');

        $response->assertStatus(200);
    }

    public function test_email_can_be_verified(): void
    {
        $user = User::factory()->unverified()->create();
        $verificationUrl = $this->tempVerificationUrl($user->id, $user->email);

        $this->actingAs($user)->get($verificationUrl);

        Event::assertDispatched(Verified::class);

        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }

    public function test_email_can_not_verified_with_invalid_hash(): void
    {
        $user = User::factory()->unverified()->create();
        $verificationUrl = $this->tempVerificationUrl($user->id, 'wrong-email');

        $response = $this->actingAs($user)->get($verificationUrl);

        $response->assertStatus(403);
        $this->assertFalse($user->fresh()->hasVerifiedEmail());
    }

    public function test_email_verification_can_be_resent(): void
    {
        $user = User::factory()->unverified()->create();
        $response = $this->actingAs($user)->post('/email/verification-notification');

        $response->assertStatus(302);

        Event::assertNotDispatched(Verified::class);
    }

    public function test_email_verification_link_can_be_used_within_a_timeframe(): void
    {
        $user = User::factory()->unverified()->create();
        $verificationUrl = $this->tempVerificationUrl($user->id, $user->email);

        $response = $this->actingAs($user)->get($verificationUrl);

        Event::assertDispatched(Verified::class);

        $response->assertStatus(302);
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }

    public function test_email_verification_link_can_not_be_used_after_expiration(): void
    {
        $user = User::factory()->unverified()->create();

        $verificationUrl = $this->expiredTempVerificationUrl($user->id, $user->email);

        $response = $this->actingAs($user)->get($verificationUrl);

        $response->assertStatus(403);
        $this->assertFalse($user->fresh()->hasVerifiedEmail());
    }

    public function test_email_verification_resend_link_has_a_limited_attempts(): void
    {
        $user = User::factory()->unverified()->create();

        for ($i = 0; $i < 3; $i++) {
            $response = $this->actingAs($user)->post('/email/verification-notification');
            $response->assertStatus(302);
        }

        $response = $this->actingAs($user)->post('/email/verification-notification');
        $response->assertStatus(429);
    }

    public function test_successful_email_verification_is_logged(): void
    {
        $user = User::factory()->unverified()->create();
        Mail::fake();
        $verificationUrl = $this->tempVerificationUrl($user->id, $user->email);

        $response = $this->actingAs($user)->get($verificationUrl);

        $response->assertStatus(302);

        $this->assertDatabaseHas('activity_log', [
            'log_name' => 'Successful Email Verification',
            'description' => "User {$user->id} has verified their email address.",
            'causer_id' => $user->id,
            'causer_type' => get_class($user),
        ]);

    }
}
