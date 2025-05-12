<?php

namespace App\Services\API;

use App\Models\Attendance;
use App\Models\WorkBalance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceService
{
    public function checkIn($data)
    {
        $user = Auth::user();
        $office = $user->office;
        $today = Carbon::today()->format('Y-m-d');

        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        if ($attendance) {
            if ($attendance->checkin) {
                return ['error' => 'Already checked in today'];
            } elseif ($attendance->checkout) {
                return ['error' => 'Already checked out today'];
            }
        }

        $radius = $office->radius;
        $distance = $this->geo_distance($data['checkin_lat'], $data['checkin_long'], $office->lat, $office->long);

        if ($distance > $radius) {
            return ['error' => 'Check-in must be within '.$radius.' of office location'];
        }

        $photoPath = $this->saveAttendancePhoto($data['checkin_photo'], 'checkin');

        $checkinTime = Carbon::createFromFormat('H:i', $data['checkin']);
        $arrivalTime = Carbon::createFromFormat('H:i', '08:00');

        $lateMinutes = 0;
        $extraMinutes = 0;

        if ($checkinTime->gt($arrivalTime)) {
            $lateMinutes = abs($checkinTime->diffInMinutes($arrivalTime));
        } elseif ($checkinTime->lt($arrivalTime)) {
            $extraMinutes = abs($arrivalTime->diffInMinutes($checkinTime));
        }

        $attendance = Attendance::create([
            'user_id' => $user->id,
            'date' => $data['date'],
            'checkin' => $data['checkin'],
            'late_minutes' => $lateMinutes,
            'extra_minutes' => $extraMinutes,
            'checkin_photo' => $photoPath,
            'checkin_lat' => $data['checkin_lat'],
            'checkin_long' => $data['checkin_long'],
            'checkin_distance' => $distance,
            'status' => 'present',
        ]);

        $balance = WorkBalance::firstOrCreate(['user_id' => $user->id], ['total_minutes' => 0]);
        $balance->total_minutes += $extraMinutes;
        $balance->total_minutes -= $lateMinutes;
        $balance->save();

        return ['attendance' => $attendance, 'balance' => $balance, 'distance' => $distance];
    }

    public function checkOut($data)
    {
        $user = Auth::user();
        $office = $user->office;

        $distance = $this->geo_distance($data['checkout_lat'], $data['checkout_long'], $office->lat, $office->long);
        $radius = $office->radius;

        if ($distance > 2) {
            return ['error' => 'Check-out must be within '.$radius.' of office location'];
        }

        $photoPath = $this->saveAttendancePhoto($data['checkout_photo'], 'checkout');

        $checkoutTime = Carbon::createFromFormat('H:i', $data['checkout']);
        $leaveTime = Carbon::createFromFormat('H:i', '16:00');

        $earlyLeave = 0;
        $extraMinutes = 0;

        if ($checkoutTime->lt($leaveTime)) {
            $earlyLeave = $leaveTime->diffInMinutes($checkoutTime);
        } elseif ($checkoutTime->gt($leaveTime)) {
            $extraMinutes = abs($checkoutTime->diffInMinutes($leaveTime));
        }

        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $data['date'])
            ->first();

        if (!$attendance) return ['not_found' => true];

        $attendance->update([
            'checkout' => $data['checkout'],
            'early_leave' => $earlyLeave,
            'extra_minutes' => $attendance->extra_minutes + $extraMinutes,
            'checkout_photo' => $photoPath,
            'checkout_lat' => $data['checkout_lat'],
            'checkout_long' => $data['checkout_long'],
            'checkout_distance' => $distance
        ]);

        $balance = WorkBalance::firstOrCreate(['user_id' => $user->id], ['total_minutes' => 0]);
        $balance->total_minutes += $earlyLeave;
        $balance->total_minutes += $extraMinutes;
        $balance->save();

        return ['attendance' => $attendance, 'balance' => $balance];
    }

    public function attendanceStatus($date) {
        $user = Auth::user();
        $attendance = Attendance::where('user_id', $user->id)->where('date', $date)->first();
        $status = '';

        if(!$attendance) {
            $status = 'checkin';
        } elseif ($attendance->checkin && !$attendance->checkout) {
            $status = 'checkout';
        } else {
            $status = 'done';
        }

        return $status;

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

    protected function geo_distance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371;

        $lat1 = floatval($lat1); $lon1 = floatval($lon1);
        $lat2 = floatval($lat2); $lon2 = floatval($lon2);

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

        return round(($earthRadius * $angle * 1000), 4);
    }
}
