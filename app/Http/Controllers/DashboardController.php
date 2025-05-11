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

        $late = Attendance::where('checkin', '>', Carbon::today()->setTime(8, 0, 0))->get();

        $todayAttendances = Attendance::with('user')
            ->whereDate('date', Carbon::today())
            ->orderBy('checkin', 'asc')
            ->get();

        $totalLateCheckins = Attendance::whereDate('date', Carbon::today())
            ->where('checkin', '>', Carbon::today()->setTime(8, 0, 0))
            ->count();

        $totalCheckins = Attendance::whereDate('date', Carbon::today())->count();

        $checkedInUserIds = Attendance::whereDate('date', Carbon::today())->pluck('user_id')->toArray();

        $notCheckedInUsers = User::whereNotIn('id', $checkedInUserIds)->get();
        $totalNotCheckedIn = $notCheckedInUsers->count();

        return view('dashboard.app', compact(
            'users',
            'excuses',
            'late',
            'todayAttendances',
            'totalLateCheckins',
            'totalCheckins',
            'totalNotCheckedIn',
            'notCheckedInUsers'
        ));
    }
}
