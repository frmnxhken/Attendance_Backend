<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index() {
        $attendances = Attendance::with('user')->get();
        return view('attendance.app', compact('attendances'));
    }
}
