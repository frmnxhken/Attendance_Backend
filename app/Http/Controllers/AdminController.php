<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Services\AdminService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function login()
    {
        return view('auth.login');
    }

    public function authentication(AuthRequest $request)
    {

        $credentials = $request->only(['email', 'password']);

        if ($this->adminService->authenticate($credentials, $request)) {
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function deauthentication(Request $request)
    {
        $this->adminService->logout($request);
        return redirect('/login');
    }

    public function editPassword()
    {
        return view('profile.edit_password');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {

        if (!$this->adminService->updatePassword(
            $request->current_password,
            $request->new_password
        )) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        return back()->with('success', 'Password updated successfully.');
    }
}
