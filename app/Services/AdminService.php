<?php

namespace App\Services;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AdminService
{
    public function authenticate(array $credentials, Request $request): bool
    {
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return true;
        }

        return false;
    }

    public function logout(Request $request): void
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    public function updatePassword(string $currentPassword, string $newPassword): bool
    {
        $user = Auth::user();
        
        if (!Hash::check($currentPassword, $user->password)) {
            return false;
        }

        Admin::findOrFail($user->id)->update([
            'password' => Hash::make($newPassword)
        ]);

        return true;
    }
}
