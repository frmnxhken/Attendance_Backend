<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $employees = $this->userService->getAllUsersWithOffices();
        return view('employee.app', compact('employees'));
    }

    public function create()
    {
        $offices = $this->userService->getAllOffices();
        return view('employee.add', compact('offices'));
    }

    public function store(UserRequest $request)
    {
        try {
            $this->userService->createUser($request->validated());
            return redirect('/employee')->with('success', 'Success addedly employee');
        } catch (\Throwable $th) {
            return redirect('/employee')->with('fail', 'Fail addedly employee');
        }
    }

    public function show(string $id)
    {
        $detail = $this->userService->getUserDetailWithAttendance($id);
        return view('employee.detail', [
            'user' => $detail['user'],
            'statistic' => $detail['statistic']
        ]);
    }

    public function edit(string $id)
    {
        $offices = $this->userService->getAllOffices();
        $employee = $this->userService->getUserWithOffice($id);
        return view('employee.edit', compact('offices', 'employee'));
    }

    public function update(UserRequest $request, string $id)
    {
        try {
            $this->userService->updateUser($id, $request->validated());
            return redirect('/employee')->with('success', 'Success edited employee');
        } catch (\Throwable $th) {
            return redirect('/employee')->with('fail', 'Fail edited employee');
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->userService->deleteUser($id);
            return redirect('/employee')->with('success', 'Success deleted employee');
        } catch (\Throwable $th) {
            return redirect('/employee')->with('fail', 'Fail deleted employee');
        }
    }
}
