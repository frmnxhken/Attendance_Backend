<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();
        $users = User::count();
        $attendances = Attendance::where('date', $today)->get();
        $presents = $attendances->where('status', 'present')->count();
        $lates = $attendances->where('status', 'present')
            ->where('late_minutes', '>', 0)->count();
        $absents = $attendances->where('status', 'absent')->count();
        $extra = $attendances->where('extra_minutes', '>', 20)->count();

        $statistic = [
            'users' => $users,
            'presents' => $presents,
            'lates' => $lates,
            'absents' => $absents
        ];

        $startDate = $today->copy()->subDays(20);

        $dates = [];
        $latesData = [];
        $extrasData = [];

        for ($date = $startDate->copy(); $date <= $today; $date->addDay()) {
            $formattedDate = $date->format('Y-m-d');
            $att = Attendance::where('date', $formattedDate)->get();

            $dates[] = $date->format('d');
            $latesData[] = $att->where('status', 'present')->where('late_minutes', '>', 0)->count();
            $extrasData[] = $att->where('extra_minutes', '>', 20)->count();
        }

        $recents = Attendance::with('user')->where('date', $today)->take(6)->get();
        return view('dashboard.app', compact('statistic', 'recents', 'dates', 'latesData', 'extrasData'));
    }
}
