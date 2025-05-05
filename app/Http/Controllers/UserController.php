<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = User::with('office')->get();
        return view('employee.app', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $offices = Office::all();
        return view('employee.add', compact('offices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'nip' => 'required|unique:users,nip',
            'name' => 'required',
            'email' => 'required|email',
            'gender' => 'required',
            'office_id' => 'required',
            'address' => 'required',
        ]);

        try {
            $validation['password'] = bcrypt($request->nip);
            User::create($validation);
            return redirect('/employee')->with('success', 'Success addedly employee');
        } catch (\Throwable $th) {
            return redirect('/employee')->with('fail', 'Fail addedly employee');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $offices = Office::all();
        $employee = User::with('office')->findOrFail($id);
        return view('employee.edit', compact('offices', 'employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validation = $request->validate([
            'nip' => 'required|unique:users,nip,' . $id,
            'name' => 'required',
            'email' => 'required|email',
            'gender' => 'required',
            'office_id' => 'required',
            'address' => 'required',
        ]);

        try {
            User::findOrFail($id)->update($validation);
            return redirect('/employee')->with('success', 'Success edited employee');
        } catch (\Throwable $th) {
            return redirect('/employee')->with('fail', 'Fail edited employee');
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $photo = $user->photo;

        if (!is_null($photo)) {
            $photoPath = public_path('employee/' . $photo);
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }

        try {
            $user->delete();
            return redirect('/employee')->with('success', 'Success deleted employee');
        } catch (\Throwable $th) {
            return redirect('/employee')->with('fail', 'Fail deleted employee');
        }
    }
}
