<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
            return response()->json(['errors' => $validation->errors()], 422);
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
            'user' => new UserResource($user)
        ]);
    }

    public function deauthentication()
    {
        $user = Auth::user();
        $user->currentAccessToken()->delete();
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
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        if (!is_null($user->photo)) {
            $oldPhotoPath = public_path($user->photo);
            if (file_exists($oldPhotoPath)) {
                unlink($oldPhotoPath);
            }
        }

        $photoName = time() . '_' . $request->file('photo')->getClientOriginalName();
        $request->file('photo')->move(public_path('uploads/photos'), $photoName);

        $user->photo = 'uploads/photos/' . $photoName;
        $user->save();

        return response()->json([
            'message' => 'Photo updated successfully',
            'photo' => asset($user->photo),
        ], 200);
    }

    public function updatePassword(Request $request) {
        $validation = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }
    
        $user = Auth::user();
    
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'Current password is incorrect.'
            ]);
        }
    
        User::findOrFail($user->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'message' => 'Password updated successfully'
        ]);
    }

    public function resetPassword(Request $request) {
        $validation = Validator::make($request->all(),[
            'nip' => 'required',
            'email' => 'required|email',
        ]);

        if($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }
        
        $user = User::where('nip', $request->nip)
        ->where('email', $request->email)->first();
        
        if(!$user) {
            return response()->json(['message' => 'Credential is Invalid']);
        }

        $user->update([
            'password' => bcrypt($user->nip)
        ]);
        
        return response()->json([
            'message' => 'Reset password successfully'
        ]);
    }
}
