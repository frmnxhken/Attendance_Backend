<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfficeRequest;
use App\Models\Office;

class OfficeController extends Controller
{
    public function index()
    {
        $offices = Office::all();
        return view('office.app', compact('offices'));
    }
    
    public function create()
    {
        return view('office.add');

    }
    public function store(OfficeRequest $request)
    {
        try {
            Office::create($request->validated());
            return redirect()->route('office.index')->with('success', 'Success addedly office');
        } catch (\Throwable $th) {
            return redirect()->route('office.index')->with('fail', 'Fail addedly office');
        }
    }

    public function edit(string $id)
    {
        $office = Office::findOrFail($id);
        return view('office.edit', compact('office'));
    }
    
    public function update(OfficeRequest $request, string $id)
    {
        try {
            Office::findOrFail($id)->update($request->validated());
            return redirect()->route('office.index')->with('success', 'Success updated office');
        } catch (\Throwable $th) {
            return redirect()->route('office.index')->with('fail', 'Fail updated office');
        }
    }

    public function destroy(string $id)
    {
        try {
            Office::findOrFail($id)->delete();
            return redirect()->route('office.index')->with('success', 'Success deleted office');
        } catch (\Throwable $th) {
            return redirect()->route('office.index')->with('fail', 'Fail deleted office');
        }
    }
}
