<?php
namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping
{
    protected $range;

    public function __construct($range)
    {
        $this->range = $range;
    }

    public function collection()
    {
        $query = Attendance::with('user')->orderBy('date', 'desc');

        if ($this->range !== 'all') {
            $end = Carbon::now();
            $start = match ($this->range) {
                '1-week' => $end->copy()->subWeek(),
                '1-month' => $end->copy()->subMonth(),
                '3-month' => $end->copy()->subMonths(3),
                '6-month' => $end->copy()->subMonths(6),
                '1-year' => $end->copy()->subYear(),
            };
            $query->whereBetween('date', [$start->format('Y-m-d'), $end->format('Y-m-d')]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Nama Karyawan',
            'Email',
            'Tanggal',
            'Waktu Check-In',
            'Waktu Check-Out',
            'Status Kehadiran',
            'Keterlambatan (Menit)',
            'Lembur (Menit)',
            'Lokasi Check-In (Lat)',
            'Lokasi Check-In (Long)',
            'Lokasi Check-Out (Lat)',
            'Lokasi Check-Out (Long)',
        ];
    }

    public function map($attendance): array
    {
        $checkinTime = Carbon::parse($attendance->checkin);
        $checkoutTime = Carbon::parse($attendance->checkout);
        $totalWorkedMinutes = $checkinTime->diffInMinutes($checkoutTime);
        $lateMinutes = $attendance->late_minutes ?? 0;
        $extraMinutes = $attendance->extra_minutes ?? 0;
        
        // Check status, if null, consider 'Absent'
        $status = $attendance->status ?? 'Absent';
        
        return [
            $attendance->user->name,
            $attendance->user->email,
            $attendance->date,
            $attendance->checkin,
            $attendance->checkout,
            $status,
            $lateMinutes,  
            $extraMinutes,
            $attendance->checkin_lat,
            $attendance->checkin_long,
            $attendance->checkout_lat,
            $attendance->checkout_long,
        ];
    }
}
