<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request){
        try{
            $credentials = $request->validate([
                'full_name' => 'required|string|regex:/^[a-zA-Z\s]*$/',
                'email' => 'required|email|max:191|unique:users',
                'password' => 'required|string|min:8|max:20|confirmed',
            ]);

            $user = User::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            return response()->json([
                'status' => true,
                'message' => 'User registered successfully!'
            ],200);

        }catch(ValidationException $e){
            return response()->json([
                'errors' => $e->validator->errors()->all()
            ], 422);
        }catch(Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
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
