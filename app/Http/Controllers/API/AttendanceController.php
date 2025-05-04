<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use App\Models\WorkBalance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
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
            return response()->json([
                'message' => $validation->errors()
            ], 422);
        }

        $office = Auth::user()->office;
        $distance = $this->calculateDistance(
            $request->checkin_lat,
            $request->checkin_long,
            $office->lat,
            $office->long
        );

        if ($distance > 2) {
            return response()->json([
                'message' => 'Check-in must be within 2KM of office location',
                'distance_km' => $distance
            ], 403);
        }

        $photoPath = $this->saveAttendancePhoto($request->file('checkin_photo'), 'checkin');

        $user = Auth::user();
        $checkinTime = Carbon::createFromFormat('H:i', $request->checkin);
        $arrivalTime = Carbon::createFromFormat('H:i', '08:00');

        $lateMinutes = null;
        $extraMinutes = null;

        // Jika datang terlambat (lebih dari jam 08:00)
        if ($checkinTime->gt($arrivalTime)) {
            $lateMinutes = abs($checkinTime->diffInMinutes($arrivalTime));
        }
        // Jika datang lebih awal
        else {
            $extraMinutes = abs($arrivalTime->diffInMinutes($checkinTime));
        }

        $attendance = Attendance::create([
            'user_id' => $user->id,
            'date' => $request->date,
            'checkin' => $request->checkin,
            'late_minutes' => $lateMinutes,
            'extra_minutes' => $extraMinutes,
            'checkin_photo' => $photoPath,
            'checkin_lat' => $request->checkin_lat,
            'checkin_long' => $request->checkin_long
        ]);

        // Update work_balances: Jika terlambat, total_minutes dikurangi
        // Jika lebih awal, total_minutes ditambah
        $balance = WorkBalance::firstOrCreate(
            ['user_id' => $user->id],
            ['total_minutes' => 0]
        );

        if ($lateMinutes) {
            // Kurangi jika terlambat
            $balance->total_minutes -= $lateMinutes; 
        } elseif ($extraMinutes) {
            // Tambah jika lebih awal
            $balance->total_minutes += $extraMinutes; 
        }

        $balance->save();

        return response()->json([
            'message' => 'Check-in recorded',
            'data' => $attendance,
            'total_minutes' => $balance->total_minutes
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
            return response()->json([
                'message' => $validation->errors()
            ], 422);
        }

        $office = Auth::user()->office;
        $distance = $this->calculateDistance(
            $request->checkin_lat,
            $request->checkin_long,
            $office->lat,
            $office->long
        );

        if ($distance > 2) {
            return response()->json([
                'message' => 'Check-in must be within 2KM of office location',
                'distance_km' => $distance
            ], 403);
        }

        $photoPath = $this->saveAttendancePhoto($request->file('checkout_photo'), 'checkout');

        $user = Auth::user();
        $checkoutTime = Carbon::createFromFormat('H:i', $request->checkout);
        $leaveTime = Carbon::createFromFormat('H:i', '16:00');

        $earlyLeave = null;
        $extraMinutes = null;

        if ($checkoutTime->lt($leaveTime)) {
            $earlyLeave = abs($leaveTime->diffInMinutes($checkoutTime)); // Positif
        } elseif ($checkoutTime->gt($leaveTime)) {
            $extraMinutes = abs($checkoutTime->diffInMinutes($leaveTime)); // Positif
        }

        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $request->date)
            ->first();

        if (!$attendance) {
            return response()->json([
                'message' => 'Attendance record not found for this date.'
            ], status: 404);
        }

        $newExtra = ($attendance->extra_minutes ?? 0) + ($extraMinutes ?? 0);

        $attendance->update([
            'checkout' => $request->checkout,
            'early_leave' => $earlyLeave,
            'extra_minutes' => $newExtra,
            'checkout_photo' => $photoPath,
            'checkout_lat' => $request->checkout_lat,
            'checkout_long' => $request->checkout_long
        ]);

        // Update total_minutes
        $balance = WorkBalance::firstOrCreate(
            ['user_id' => $user->id],
            ['total_minutes' => 0]
        );

        if ($earlyLeave) {
            $balance->total_minutes -= abs($earlyLeave);
        }

        if ($extraMinutes) {
            $balance->total_minutes += abs($extraMinutes);
        }

        $balance->save();

        return response()->json([
            'message' => 'Check-out recorded',
            'data' => $attendance,
            'total_minutes' => $balance->total_minutes
        ]);
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371;
        $lat1 = floatval($lat1);
        $lon1 = floatval($lon1);
        $lat2 = floatval($lat2);
        $lon2 = floatval($lon2);

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(
            pow(sin($latDelta / 2), 2) +
                cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)
        ));

        //km format
        return round($earthRadius * $angle, 4); 
    }

    protected function saveAttendancePhoto($file, $type = 'checkin')
    {
        if (!in_array($type, ['checkin', 'checkout'])) {
            throw new \InvalidArgumentException('Invalid attendance photo type.');
        }

        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $folder = 'uploads/' . $type;
        $destination = public_path($folder);

        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        $file->move($destination, $filename);

        return $folder . '/' . $filename;
    }
}