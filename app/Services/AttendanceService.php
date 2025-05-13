<?php

namespace App\Services;

use App\Models\Attendance;
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
}
