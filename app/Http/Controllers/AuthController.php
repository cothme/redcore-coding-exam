<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        $this->authorize('create-delete-users');
        $user = User::create($request->validated());

        return response($user);
    }
    public function login(Request $request){
        if(!Auth::attempt($request->only('email','password'))){
            return response([
                'error' => 'Invalid credentials'
            ],Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();
        $token = $user->createToken('MyApp')->plainTextToken;

        return response([
            'token' => $token
        ]);
    }

    public function logout(Request $request){
        auth()->user()->currentAccessToken()->delete();

        return response([
            'message' => 'Successfully logged out'
        ]);
    }
}
