<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function authentication(Request $request) {
        $validation = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'    
        ]);

        if($validation->fails()) {
            return response()->json(['message' => $validation->errors()]);
        }

        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);

    }

    public function deauthentication() {
        // Skip for now
    }

    public function getProfile() {
        $profile = User::with('office')->findOrFail(Auth::user()->id);
        return response()->json([
            'message' => 'Information Personal',
            'data' => new UserResource($profile)
        ]);
    }
}
