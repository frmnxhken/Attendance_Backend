<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping, WithEvents
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
                default => $end->copy()->subWeek(),
            };
            $query->whereBetween('date', [$start->format('Y-m-d'), $end->format('Y-m-d')]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Email',
            'Tanggal',
            'Check-In',
            'Jarak Check-In (m)',
            'Check-Out',
            'Jarak Check-Out (m)',
            'Status',
            'Keterlambatan (menit)',
            'Lembur (menit)',
            'Check-In (lat)',
            'Check-In (long)',
            'Check-Out (lat)',
            'Check-Out (long)',
        ];
    }

    public function map($attendance): array
    {
        return [
            $attendance->user->name,
            $attendance->user->email,
            $attendance->date,
            $attendance->checkin,
            $attendance->checkin_distance,
            $attendance->checkout,
            $attendance->checkout_distance,
            $attendance->status,
            $attendance->late_minutes ?? 0,
            $attendance->extra_minutes ?? 0,
            $attendance->checkin_lat,
            $attendance->checkin_long,
            $attendance->checkout_lat,
            $attendance->checkout_long,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $columnCount = count($this->headings());
                $highestRow = $sheet->getHighestRow();
                $columnRange = range('A', chr(64 + $columnCount)); // Misal A to M

                foreach ($columnRange as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                $sheet->getStyle("A1:" . chr(64 + $columnCount) . "1")
                      ->getFont()->setBold(true);

                $sheet->getStyle("A1:" . chr(64 + $columnCount) . $highestRow)
                      ->applyFromArray([
                          'borders' => [
                              'allBorders' => [
                                  'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                  'color' => ['argb' => '000000'],
                              ],
                          ],
                      ]);
            },
        ];
    }
}
