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
    public function authentication(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validation->fails()) {
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

    public function deauthentication()
    {
        $user = Auth::user();
        $user->tokens()->delete();
        return response()->json([
            'message' => 'Logout successful'
        ]);
    }

    public function getProfile()
    {
        $profile = User::with('office')->findOrFail(Auth::user()->id);
        return response()->json([
            'message' => 'Information Personal',
            'data' => new UserResource($profile)
        ]);
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Validasi file foto
        ]);

        $user = Auth::user();

        // Hapus foto lama kalo ada
        if (!is_null($user->photo)) {
            $oldPhotoPath = public_path($user->photo);
            if (file_exists($oldPhotoPath)) {
                unlink($oldPhotoPath);
            }
        }

        // Simpan foto baru
        $photoName = time() . '_' . $request->file('photo')->getClientOriginalName();
        $request->file('photo')->move(public_path('uploads/photos'), $photoName);

        // Update kolom foto di database
        $user->photo = 'uploads/photos/' . $photoName;
        $user->save();

        return response()->json([
            'message' => 'Photo updated successfully',
            'photo_url' => asset($user->photo),
        ], 200);
    }
}
