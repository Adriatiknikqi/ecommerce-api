<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Api\V1\RegisterRequest;
use App\Http\Requests\Api\V1\LoginRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest  $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('ecommerce-frontend')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        
        if (! Auth::attempt($request->only('email', 'password'), true)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 422);
        }

        $user = $request->user();

        // opsionale: fshij tokenat e vjetër (vetëm 1 device)
        // $user->tokens()->delete();

        $token = $user->createToken('ecommerce-frontend')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function me(Request $request)
    {
        return response()->json(['user' => $request->user()]);
    }

    public function logout(Request $request)
    {
         $request->user()->currentAccessToken()->delete();

         return response()->json(['ok' => true]);
    }
}
