<?php

namespace App\Http\Api\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController
{
    public function __invoke(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = $request->user();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'type_token' => 'Bearer',
                'user_roles' => $user->roles->pluck('name'),
            ], 200);
        }

        return response()->json([
            'error' => 'Não autorizado.',
        ], 401);
    }
}
