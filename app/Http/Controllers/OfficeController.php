<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offices = Office::all();
        return view('office.app', compact('offices'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('office.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|unique:offices,name',
            'long' => 'required',
            'lat' => 'required',
            'address' => 'required'
        ]);

        try {
            Office::create($validation);
            return redirect('/office')->with('success', 'Success addedly office');
        } catch (\Throwable $th) {
            return redirect('/office')->with('fail', 'Fail addedly office');
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
        $office = Office::findOrFail($id);
        return view('office.edit', compact('office'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validation = $request->validate([
            'name' => 'required|unique:offices,name,'.$id,
            'long' => 'required',
            'lat' => 'required',
            'address' => 'required'
        ]);

        try {
            Office::findOrFail($id)->update($validation);
            return redirect('/office')->with('success', 'Success updated office');
        } catch (\Throwable $th) {
            return redirect('/office')->with('fail', 'Fail updated office');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Office::findOrFail($id)->delete();
            return redirect('/office')->with('success', 'Success deleted office');
        } catch (\Throwable $th) {
            return redirect('/office')->with('fail', 'Fail deleted office');
        }
    }
}
