<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            $user->tokens()->delete();
            $token = $user->createToken(request()->userAgent());
            return response()->json([
                'token' => $token->plainTextToken,
                'success' => "Login successful",
            ], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
    public function logout()
    {
        $user = Auth::user();
    
        if ($user) {
            $user->currentAccessToken()->delete();
            
        } 
        return response()->json(['message' => 'Logout successful']);
    }
}
