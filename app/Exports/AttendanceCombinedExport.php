<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AttendanceCombinedExport implements WithMultipleSheets
{
    protected $range;

    public function __construct($range)
    {
        $this->range = $range;
    }

    public function sheets(): array
    {
        $attendances = \App\Models\Attendance::with('user');

        if ($this->range !== 'all') {
            $end = Carbon::now();
            $start = match ($this->range) {
                '1-week' => $end->copy()->subWeek(),
                '1-month' => $end->copy()->subMonth(),
                '3-month' => $end->copy()->subMonths(3),
                '6-month' => $end->copy()->subMonths(6),
                '1-year' => $end->copy()->subYear(),
                default => $end->copy()->subWeek(),
            };

            $attendances->whereBetween('date', [$start->format('Y-m-d'), $end->format('Y-m-d')]);
        }

        $attendances = $attendances->get();
        $rekap = [];

        foreach ($attendances->groupBy('user_id') as $userId => $items) {
            $user = $items->first()->user;
            $kehadiran = $items->where('status', 'present')->count();
            $absent = $items->where('status', 'absent')->count();
            $lembur = $items->sum('extra_minutes');
            $telat = $items->sum('late_minutes');
            $balance = $lembur - $telat;

            $rekap[] = [
                $user->name,
                $kehadiran,
                $absent,
                $lembur,
                $telat,
                $balance,
            ];
        }

        return [
            new AttendanceRecapExport($rekap),
            new AttendanceExport($this->range),
        ];
    }
}
