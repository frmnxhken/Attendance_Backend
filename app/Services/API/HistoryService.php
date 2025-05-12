<?php

namespace App\Services\API;

use App\Models\Attendance;
use App\Models\WorkBalance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HistoryService
{
    public function getTodayStatistics()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)->first();
        $attendances = Attendance::where('user_id', $user->id)->orderBy('id', 'DESC')->get();
        $balance = WorkBalance::where('user_id', $user->id)->first();

        return [
            'statistic' => [
                'checkin' => $attendance?->checkin,
                'checkout' => $attendance?->checkout,
                'balance' => $balance->total_minutes ?? 0,
                'attended' => $attendances->count(),
            ],
            'histories' => $attendances->take(5),
        ];
    }

    public function getHistoryStatistics()
    {
        $user = Auth::user();
        $attendances = Attendance::where('user_id', $user->id)->get();

        return [
            'statistic' => [
                'present' => $attendances->where('status', 'present')->count(),
                'late' => $attendances->where('status', 'present')->where('late_minutes', '>', 0)->count(),
                'excused' => $attendances->where('status', 'excuse')->count(),
                'absent' => $attendances->where('status', 'absent')->count(),
            ],
            'histories' => $attendances,
        ];
    }
}
