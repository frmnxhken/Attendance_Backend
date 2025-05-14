<?php

namespace App\Http\Controllers;

use App\Http\Requests\WeeklyHollidayRequest;
use App\Models\WeeklyHolliday;
use Carbon\Carbon;

class WeeklyHollidayController extends Controller
{
    public $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

    public function index()
    {
        $weeklies = WeeklyHolliday::get();
        return view('weekly.app', compact('weeklies'));
    }

    public function create()
    {
        return view('weekly.add', ['days' => $this->days]);
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
        return view('weekly.edit', ['holiday' => $holiday, 'days' => $this->days]);
    }

    public function update(WeeklyHollidayRequest $request, $id)
    {
        try {
            WeeklyHolliday::findOrFail($id)->update($request->validated());
            return redirect()->route('weekly.index')->with('success', 'Success updated weekly');
        } catch (\Throwable $th) {
            return redirect()->route('weekly.index')->with('fail', 'Fail updated weekly');
        }
    }

    public function destroy($id)
    {
        try {
            WeeklyHolliday::findOrFail($id)->delete();
            return redirect()->route('weekly.index')->with('success', 'Success deleted weekly');
        } catch (\Throwable $th) {
            return redirect()->route('weekly.index')->with('fail', 'Fail deleted weekly');
        }
    }
}
