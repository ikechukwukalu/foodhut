<?php

namespace App\Services;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginService
{

    /**
     * Handle the request.
     *
     * @param  \App\Http\Requests\LoginRequest  $request
     * @return ?array
     */
    public static function handleLogin(LoginRequest $request): ?array
    {
        $validated = $request->validated();

        if (!Auth::attempt($validated, true)) {
            return null;
        }

        $token = Auth::user()->createToken($validated['email']);

        return [
            'access_token' => $token->plainTextToken,
            'message' => trans('auth.success')
        ];
    }
}
