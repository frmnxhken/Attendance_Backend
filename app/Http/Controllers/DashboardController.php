<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Excuse;
use App\Models\Attendance;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $users = User::orderBy('name')->get();

        $excuses = Excuse::where('status', 'pending')->get();

        $late = Attendance::where('checkin', '>', Carbon::today()->setTime(8, 0, 0))->get();

        $todayAttendances = Attendance::with('user')
            ->whereDate('date', Carbon::today())
            ->orderBy('checkin', 'asc')
            ->take(5)
            ->get();

        $totalLateCheckins = Attendance::whereDate('date', Carbon::today())
            ->where('checkin', '>', Carbon::today()->setTime(8, 0, 0))
            ->count();

        $totalCheckins = Attendance::whereDate('date', Carbon::today())->count();

        $checkedInUserIds = Attendance::whereDate('date', Carbon::today())->pluck('user_id')->toArray();

        $notCheckedInUsers = User::whereNotIn('id', $checkedInUserIds)->get();
        $totalNotCheckedIn = $notCheckedInUsers->count();

        $attendances = Attendance::whereNotNull('checkin')
            ->orderBy('date', 'asc')
            ->get()
            ->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->date)->format('Y-m'); // gunakan Carbon::parse
            });
        // dd($attendances);
        // dd($attendances->toArray());

        $attendanceChartData = [];

        foreach ($attendances as $month => $items) {
            $total = $items->count();
            $late = $items->filter(function ($item) {
                return $item->checkin > '08:00:00'; // Karena ini string TIME, banding langsung
            })->count();
                // echo $late;
            $attendanceChartData[] = [
                'month' => $month,
                'attendance' => $total,
                'late' => $late
            ];
        }
        
        // dd($attendanceChartData);
        return view('dashboard.app', compact(
            'users',
            'excuses',
            'late',
            'todayAttendances',
            'totalLateCheckins',
            'totalCheckins',
            'totalNotCheckedIn',
            'notCheckedInUsers',
            'attendanceChartData',
        ));
    }
}
