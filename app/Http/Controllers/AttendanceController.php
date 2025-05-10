<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('user')
            ->orderBy('date', 'desc')
            ->get()
            ->groupBy(function ($attendance) {
                return Carbon::parse($attendance->date)->format('Y-m-d');
            });

        return view('attendance.app', compact('attendances'));
    }
}
