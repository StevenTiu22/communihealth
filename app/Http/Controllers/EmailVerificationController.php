<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function store(Request $request): mixed
    {
        $key = 'verification-send='. Carbon::now()->toDateString() . $request->user()->id;
        $maxAttempt = config('auth.email-verification.resend_limit');

        $rateLimiter = app(RateLimiter::class);

        if ($rateLimiter->tooManyAttempts($key, $maxAttempt)) {
            return response()->json([
                'message' => 'Too many attempts. Please try again later.'
            ], 429);
        }

        $rateLimiter->hit($key);

        return back()->with('message', 'Verification link sent!');
    }
}
