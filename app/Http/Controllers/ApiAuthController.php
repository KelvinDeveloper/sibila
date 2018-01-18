<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use JWTAuth;
use JWTFactory;
use Hash;
use DB;

class ApiAuthController extends Controller
{

    public function store(Request $request)
    {
        // Get only email and password from request
        $credentials = $request->only('email', 'password');

        // Get user by email
        $user = User::where('email', $credentials['email'])->first();

        // Validate User
        if (! $user) {
            return response()->json([
                'error' => 'Invalid email'
            ], 401);
        }

        // Validate Password
         if (!Hash::check($credentials['password'], $user->password)) {

            return response()->json([
                'error' => 'Invalid password'
            ], 401);
        }

        // Generate Token
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'access_token' => $token,
            'user' => $user
        ]);
    }
}

