<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CheckOutRequest;
use App\Http\Requests\API\ChekInRequest;
use App\Services\API\AttendanceService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    protected $service;

    public function __construct(AttendanceService $service)
    {
        $this->service = $service;
    }

    public function checkIn(ChekInRequest $request)
    {
        $result = $this->service->checkIn($request->all());

        if (isset($result['error'])) {
            return response()->json(['message' => $result['error']], 403);
        }

        return response()->json([
            'message' => 'Check-in recorded',
            'data' => $result['attendance'],
            'total_minutes' => $result['balance']->total_minutes
        ]);
    }

    public function checkOut(CheckOutRequest $request)
    {
        $result = $this->service->checkOut($request->all());

        if (isset($result['error'])) {
            return response()->json(['message' => $result['error']], 403);
        }

        if (isset($result['not_found'])) {
            return response()->json(['message' => 'Attendance record not found for this date.'], 404);
        }

        return response()->json([
            'message' => 'Check-out recorded',
            'data' => $result['attendance'],
            'total_minutes' => $result['balance']->total_minutes
        ]);
    }

    public function checkStatus()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $status = $this->service->attendanceStatus($today);

        return response()->json([
            'message' => 'Status attendance today',
            'attendance' => $status,
            'office_lat' => $user->office->lat,
            'office_long' => $user->office->long,
        ]);
    }
}
