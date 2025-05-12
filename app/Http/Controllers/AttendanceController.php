<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $attendancesQuery = Attendance::with('user')
            ->orderBy('date', 'desc');

        if ($startDate && $endDate) {
            $attendancesQuery->whereBetween('date', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        }

        $attendances = $attendancesQuery->get()
            ->groupBy(function ($attendance) {
                return Carbon::parse($attendance->date)->format('Y-m-d');
            });

        return view('attendance.app', compact('attendances', 'startDate', 'endDate'));
    }
}
