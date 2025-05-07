<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Services\AttendanceService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    protected $service;

    public function __construct(AttendanceService $service)
    {
        $this->service = $service;
    }

    public function checkIn(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'date' => 'required|date|unique:attendances,date',
            'checkin' => 'required|date_format:H:i',
            'checkin_long' => 'required',
            'checkin_lat' => 'required',
            'checkin_photo' => 'required'
        ]);


        if ($validation->fails()) {
            return response()->json(['message' => $validation->errors()], 422);
        }

        $result = $this->service->checkIn($request->all());

        if (isset($result['error'])) {
            return response()->json(['message' => $result['error'], 'distance_km' => $result['distance']], 403);
        }

        return response()->json([
            'message' => 'Check-in recorded',
            'data' => $result['attendance'],
            'total_minutes' => $result['balance']->total_minutes
        ]);
    }

    public function checkOut(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'date' => 'required|date',
            'checkout' => 'required|date_format:H:i',
            'checkout_long' => 'required',
            'checkout_lat' => 'required',
            'checkout_photo' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json(['message' => $validation->errors()], 422);
        }

        $result = $this->service->checkOut($request->all());

        if (isset($result['error'])) {
            return response()->json(['message' => $result['error'], 'distance_km' => $result['distance']], 403);
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

    public function checkStatus() {
        $today = Carbon::today();

        $status = $this->service->attendanceStatus($today);
        return response()->json([
            'message' => 'Status attendance today',
            'status' => $status
        ]);
    }
}