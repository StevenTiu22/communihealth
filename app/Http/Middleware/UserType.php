<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $type = null): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userType = auth()->user()->user_type;

        if ($userType !== $type) {
            abort(403, 'Unauthorized action.');
        }

        return next($request);
    }
}
