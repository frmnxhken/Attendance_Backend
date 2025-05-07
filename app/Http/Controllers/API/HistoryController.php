<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;
use App\Models\WorkBalance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function recent()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)->first();
        $attendances = Attendance::where('user_id', $user->id)->orderBy('id', 'DESC')->get();
        $balance = WorkBalance::where('user_id', $user->id)->first();

        $todayStatistic = [
            'checkin' => $attendance?->checkin,
            'checkout' => $attendance?->checkout,
            'balance' => $balance->total_minutes,
            'attended' => $attendances->count(),
        ];

        return response()->json([
            'message' => 'Today Attendance',
            'data' => [
                'statistic' => $todayStatistic,
                'histories' => AttendanceResource::collection($attendances->take(5))
            ]
        ]);
    }

    public function histories()
    {
        $user = Auth::user();
        $attendances = Attendance::where('user_id', $user->id)->get();

        $statistic = [
            'present' => $attendances->where('status', 'present')->count(),
            'late' => $attendances->where('status', 'present')->where('late_minutes', '>', 0)->count(),
            'excused' => $attendances->where('status', 'excuse')->count(),
            'absent' => $attendances->where('status', 'absent')->count()
        ];

        return response()->json([
            'message' => 'Histories Attendance',
            'data' => [
                'statistic' => $statistic,
                'histories' => AttendanceResource::collection($attendances)
            ]
        ]);
    }
}
