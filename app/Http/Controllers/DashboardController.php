<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Excuse;
use App\Models\Attendance;
use Carbon\Carbon;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();

        $excuses = Excuse::where('status', 'pending')->get();

        $todayAttendances = Attendance::with('user')
            ->whereDate('date', Carbon::today())
            ->orderBy('checkin', 'asc')
            ->get();

        $totalLateCheckins = Attendance::whereDate('date', Carbon::today())
            ->where('checkin', '>', Carbon::today()->setTime(8, 0, 0))
            ->count();

        return view('dashboard.app', compact(
            'users',
            'excuses',
            'todayAttendances',
            'totalLateCheckins'
        ));
    }
}
