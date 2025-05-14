<?php

namespace App\Http\Controllers;

use App\Http\Requests\SpecialHollidayRequest;
use App\Models\SpecialHolliday;

class SpecialHollidayController extends Controller
{
    public function index()
    {
        $hollidays = SpecialHolliday::get();
        return view('special.app', compact('hollidays'));
    }

    public function create()
    {
        return view('special.add');
    }

    public function store(SpecialHollidayRequest $request)
    {
        try {
            SpecialHolliday::create($request->validated());
            return redirect()->route('special.index')->with('success', 'Success addedly special');
        } catch (\Throwable $th) {
            return redirect()->route('special.index')->with('fail', 'Fail addedly special');
        }
    }

    public function edit($id)
    {
        $holliday = SpecialHolliday::findOrFail($id);
        return view('special.edit', compact('holliday'));
    }

    public function update(SpecialHollidayRequest $request, $id) {
         try {
            SpecialHolliday::findOrFail($id)->update($request->validated());
            return redirect()->route('special.index')->with('success', 'Success updated special');
        } catch (\Throwable $th) {
            return redirect()->route('special.index')->with('fail', 'Fail updated special');
        }
    }

    public function destroy($id) {
        try {
            SpecialHolliday::findOrFail($id)->delete();
            return redirect()->route('special.index')->with('success', 'Success deleted special');
        } catch (\Throwable $th) {
            return redirect()->route('special.index')->with('fail', 'Fail deleted special');
        }
    }
}
