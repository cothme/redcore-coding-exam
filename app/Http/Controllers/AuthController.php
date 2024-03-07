<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request){
        try{
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            
            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'message' => 'Invalid credentials',
                ],401);
            }

            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'access_token' => $token
            ]);

        }catch(Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
        
    }

    public function logout(Request $request){
        $user = $request->user();
        try{
            $user->tokens()->delete();
            return response()->json([
                'message' => 'User logged out successfully'
            ],200);
        }catch(Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}
