<?php

namespace App\Http\Controllers;

use App\Http\Requests\WeeklyHollidayRequest;
use App\Models\WeeklyHolliday;
use Carbon\Carbon;

class WeeklyHollidayController extends Controller
{
    public function index()
    {
        $today = Carbon::now()->locale('l');
        $dayName = $today->translatedFormat('l');
        $weeklies = WeeklyHolliday::get();
        return view('weekly.app', compact('weeklies'));
    }

    public function create()
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        return view('weekly.add', compact('days'));
    }

    public function store(WeeklyHollidayRequest $request)
    {
        try {
            WeeklyHolliday::create($request->validated());
            return redirect()->route('weekly.index')->with('success', 'Success addedly weekly');
        } catch (\Throwable $th) {
            return redirect()->route('weekly.index')->with('fail', 'Fail addedly weekly');
        }
    }

    public function edit($id)
    {
        $holiday = WeeklyHolliday::findOrFail($id);
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        return view('weekly.edit', compact('holiday', 'days'));
    }

    public function update(WeeklyHollidayRequest $request, $id) {
         try {
            WeeklyHolliday::findOrFail($id)->update($request->validated());
            return redirect()->route('weekly.index')->with('success', 'Success updated weekly');
        } catch (\Throwable $th) {
            return redirect()->route('weekly.index')->with('fail', 'Fail updated weekly');
        }
    }

    public function destroy($id) {
        try {
            WeeklyHolliday::findOrFail($id)->delete();
            return redirect()->route('weekly.index')->with('success', 'Success deleted weekly');
        } catch (\Throwable $th) {
            return redirect()->route('weekly.index')->with('fail', 'Fail deleted weekly');
        }
    }
}
