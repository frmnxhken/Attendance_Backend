<?php

namespace App\Services\API;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class UserService
{
    public function authenticate($credentials)
    {
        if (!Auth::attempt($credentials)) {
            return ['success' => false, 'message' => 'Invalid credentials'];
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'success' => true,
            'access_token' => $token,
            'user' => new UserResource($user)
        ];
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();
    }

    public function getProfile()
    {
        $profile = User::with('office')->findOrFail(Auth::id());
        return new UserResource($profile);
    }

    public function updatePhoto(Request $request)
    {
        $user = Auth::user();

        if ($user->photo && file_exists(public_path($user->photo))) {
            unlink(public_path($user->photo));
        }

        $photoName = time() . '_' . $request->file('photo')->getClientOriginalName();
        $request->file('photo')->move(public_path('uploads/photos'), $photoName);

        $user->update(['photo' => 'uploads/photos/' . $photoName]);

        return asset($user->photo);
    }

    public function updatePassword($current, $new)
    {
        $user = Auth::user();

        if (!Hash::check($current, $user->password)) {
            return ['success' => false, 'message' => 'Current password is incorrect.'];
        }

        $user->update(['password' => Hash::make($new)]);
        return ['success' => true];
    }

    public function resetPassword($nip, $email)
    {
        $user = User::where('nip', $nip)->where('email', $email)->first();

        if (!$user) {
            return ['success' => false, 'message' => 'Credential is invalid'];
        }

        $user->update(['password' => Hash::make($user->nip)]);
        return ['success' => true];
    }
}
