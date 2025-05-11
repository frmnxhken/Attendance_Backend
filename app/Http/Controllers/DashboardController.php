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

        $range = $request->get('range', '1Y'); // default 1Y
        $end = Carbon::today();
        switch ($range) {
            case '6M':
                $start = $end->copy()->subMonths(6)->startOfMonth();
                break;
            case '1M':
                $start = $end->copy()->subMonth()->startOfMonth();
                break;
            case 'ALL':
                $start = Attendance::min('date') ?? Carbon::today()->subYear();
                break;
            case '1Y':
            default:
                $start = $end->copy()->subYear()->startOfMonth();
                break;
        }

        $period = CarbonPeriod::create($start, '1 month', $end);
        $labels = [];
        $attendances = [];
        $lates = [];

        foreach ($period as $date) {
            $month = $date->format('Y-m');
            $labels[] = $date->format('M Y');

            $monthlyData = Attendance::whereBetween('date', [
                $date->copy()->startOfMonth(),
                $date->copy()->endOfMonth()
            ]);

            $attendances[] = $monthlyData->count();
            $lates[] = $monthlyData->where('checkin', '>', $date->copy()->setTime(8, 0, 0))->count();
        }

        return view('dashboard.app', compact(
            'users',
            'excuses',
            'late',
            'todayAttendances',
            'totalLateCheckins',
            'totalCheckins',
            'totalNotCheckedIn',
            'notCheckedInUsers'
        ))->with([
            'chartLabels' => $labels,
            'chartAttendances' => $attendances,
            'chartLates' => $lates,
            'selectedRange' => $range,
        ]);
    }
}
