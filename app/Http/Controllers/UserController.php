<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Attendance;
use App\Models\Office;
use App\Models\User;

class UserController extends Controller
{

    public function index()
    {
        $employees = User::with('office')->get();
        return view('employee.app', compact('employees'));
    }

    public function create()
    {
        $offices = Office::all();
        return view('employee.add', compact('offices'));
    }

    public function store(UserRequest $request)
    {
        try {
            $data = $request->validated();
            $data['password'] = bcrypt($data['nip']);
            User::create($data);
            return redirect('/employee')->with('success', 'Success addedly employee');
        } catch (\Throwable $th) {
            return redirect('/employee')->with('fail', 'Fail addedly employee');
        }
    }

    public function show(string $id)
    {
        $attendance = Attendance::where('user_id', $id)->get();
        $user = User::where('id', $id)->first();
        $statistic = [
            'present' => $attendance->where('status', 'present')->count(),
            'late' => $attendance->where('status', 'present')->where('late_minutes', '>', 0)->count(),
            'excused' => $attendance->where('status', 'excuse')->count(),
            'absent' => $attendance->where('status', 'absent')->count()
        ];

        return view('employee.detail', compact('statistic', 'user'));
    }

    public function edit(string $id)
    {
        $offices = Office::all();
        $employee = User::with('office')->findOrFail($id);
        return view('employee.edit', compact('offices', 'employee'));
    }

    public function update(UserRequest $request, string $id)
    {
        try {
            User::findOrFail($id)->update($request->validated());
            return redirect('/employee')->with('success', 'Success edited employee');
        } catch (\Throwable $th) {
            return redirect('/employee')->with('fail', 'Fail edited employee');
        }
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->photo && file_exists(public_path("employee/{$user->photo}"))) {
            @unlink(public_path("employee/{$user->photo}"));
        }

        try {
            $user->delete();
            return redirect('/employee')->with('success', 'Success deleted employee');
        } catch (\Throwable $th) {
            return redirect('/employee')->with('fail', 'Fail deleted employee');
        }
    }
}
