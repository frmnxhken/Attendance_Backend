<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Excuse;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();
        $checkinDeadline = '08:00:00';

        $users = User::orderBy('name')->get();
        $excuses = Excuse::where('status', 'pending')->get();

        $todayAttendancesQuery = Attendance::with('user')
            ->whereDate('date', $today);

        $todayAttendances = (clone $todayAttendancesQuery)
            ->orderBy('checkin', 'asc')
            ->take(5)
            ->get();

        $todayAttendancesAll = $todayAttendancesQuery->get();

        $totalCheckins = $todayAttendancesAll->count();
        $totalLateCheckins = $todayAttendancesAll
            ->where('checkin', '>', $checkinDeadline)
            ->count();

        $checkedInUserIds = $todayAttendancesAll->pluck('user_id');
        $notCheckedInUsers = $users->whereNotIn('id', $checkedInUserIds);
        $totalNotCheckedIn = $notCheckedInUsers->count();

        $attendanceChartData = Attendance::whereNotNull('checkin')
            ->orderBy('date')
            ->get()
            ->groupBy(fn($item) => Carbon::parse($item->date)->format('Y-m'))
            ->map(fn($items, $month) => [
                'month' => $month,
                'attendance' => $items->count(),
                'late' => $items->where('checkin', '>', $checkinDeadline)->count(),
            ])
            ->values()
            ->all();

        return view('dashboard.app', compact(
            'users',
            'excuses',
            'todayAttendances',
            'totalLateCheckins',
            'totalCheckins',
            'totalNotCheckedIn',
            'notCheckedInUsers',
            'attendanceChartData',
        ));
    }
}
