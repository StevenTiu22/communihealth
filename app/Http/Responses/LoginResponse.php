<?php

namespace App\Http\Responses;

use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{

    public function toResponse($request): JsonResponse|RedirectResponse
    {
        $path = RedirectIfAuthenticated::getRedirectPath(Auth::user());
        return $request->wantsJson()
            ? response()->json(['two_factor' => false])
            : redirect()->intended($path);
    }

}
