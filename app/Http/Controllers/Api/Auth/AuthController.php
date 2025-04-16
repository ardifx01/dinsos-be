<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|string|max:255',
            'password' => 'required|string|max:255'
        ]);

        $credentials = $request->only('email', 'password');
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['message' => 'Email or password is wrong'], 401);  
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json([
            'message' => 'Successully get current user',
            'data' => auth()->user()
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
            ],
            'message' => 'Successully logged in'
        ]);
    }
}
