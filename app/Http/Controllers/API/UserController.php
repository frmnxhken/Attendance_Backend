<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\AuthRequest;
use App\Http\Requests\API\ResetPasswordRequest;
use App\Http\Requests\API\UpdatePasswordRequest;
use App\Http\Requests\API\UpdatePhotoRequest;
use App\Http\Resources\UserResource;
use App\Services\API\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function authentication(AuthRequest $request)
    {

        $result = $this->userService->authenticate($request->only(['email', 'password']));

        if (!$result['success']) {
            return response()->json([
                'message' => $result['message']
            ], 401);
        }

        return response()->json([
            'message' => 'Login successful',
            'access_token' => $result['access_token'],
            'token_type' => 'Bearer',
            'user' => new UserResource($result['user'])
        ]);
    }

    public function deauthentication()
    {
        $this->userService->logout();
        return response()->json(['message' => 'Logout successful']);
    }

    public function getProfile()
    {
        $profile = $this->userService->getProfile();
        return response()->json([
            'message' => 'Information Personal',
            'data' => $profile
        ]);
    }

    public function updatePhoto(UpdatePhotoRequest $request)
    {
        $photo = $this->userService->updatePhoto($request);
        return response()->json([
            'message' => 'Photo updated successfully',
            'photo' => $photo,
        ]);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $result = $this->userService->updatePassword($request->current_password, $request->new_password);

        if (!$result['success']) {
            return response()->json(['message' => $result['message']]);
        }

        return response()->json(['message' => 'Password updated successfully']);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $result = $this->userService->resetPassword($request->nip, $request->email);

        if (!$result['success']) {
            return response()->json(['message' => $result['message']]);
        }

        return response()->json([
            'message' => 'Reset password successfully'
        ]);
    }
}