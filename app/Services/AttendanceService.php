<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\SpecialHolliday;
use App\Models\User;
use App\Models\WeeklyHolliday;
use App\Models\WorkBalance;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class AttendanceService
{
    public function getGroupedAttendances(?string $startDate, ?string $endDate, int $perPage, int $currentPage)
    {
        $query = Attendance::with('user')->orderBy('date', 'DESC');

        if ($startDate && $endDate) {
            $query->whereBetween('date', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        } else {
            $query->whereDate('date', '<=', Carbon::today()->toDateString());
        }

        $grouped = $query->get()->groupBy(function ($attendance) {
            return Carbon::parse($attendance->date)->toDateString();
        });

        $allDates = array_keys($grouped->toArray());
        $totalDates = count($allDates);
        $totalPages = ceil($totalDates / $perPage);

        $pagedDates = array_slice($allDates, ($currentPage - 1) * $perPage, $perPage);
        $pagedAttendances = collect($grouped)->only($pagedDates);

        return [
            'attendances' => $pagedAttendances,
            'totalPages' => $totalPages
        ];
    }

    public function resetPhotos(): void
    {
        Attendance::query()->update(['checkin_photo' => null, 'checkout_photo' => null]);
        File::cleanDirectory(public_path('uploads/checkin'));
        File::cleanDirectory(public_path('uploads/checkout'));
    }

    public function resetAll(): void
    {
        Attendance::truncate();
        File::cleanDirectory(public_path('uploads/checkin'));
        File::cleanDirectory(public_path('uploads/checkout'));
    }

    public function resetBalance(): void
    {
        WorkBalance::truncate();
    }

    public function checkUpToday()
    {
        $today = Carbon::today()->format('Y-m-d');
        $dayName = Carbon::parse($today)->format('l');

        $weeklyHoliday = WeeklyHolliday::where('day', $dayName)->first();
        if ($weeklyHoliday) {
            return ['warning' => 'Today is a weekly holiday'];
        }

        $specialHoliday = SpecialHolliday::where('date', $today)->first();
        if ($specialHoliday) {
            return ['warning' => 'Today is a ' . $specialHoliday->description . ' holiday'];
        }

        $users = User::all();

        foreach ($users as $user) {
            $attendance = Attendance::where('user_id', $user->id)
                ->whereDate('date', $today)
                ->first();

            $arrival = $user->office->arrival;
            $leave = $user->office->leave;
            $start = Carbon::createFromFormat('H:i:s', $leave);
            $end = Carbon::createFromFormat('H:i:s', $arrival);
            $balanceTime = $end->diffInMinutes($start);

            $balance = WorkBalance::firstOrCreate(
                ['user_id' => $user->id],
                ['total_minutes' => 0]
            );

            if (!$attendance) {
                Attendance::create([
                    'user_id' => $user->id,
                    'date' => $today,
                    'status' => 'absent',
                ]);
                $balance->total_minutes -= $balanceTime;
                $balance->save();
            } else if (is_null($attendance->checkout) && $attendance->status === 'present') {
                $attendance->update(['status' => 'absent']);
                $balance->total_minutes -= $balanceTime;
                $balance->save();
            }
        }

        return ['success' => 'Check up completed'];
    }
}
