<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceRecapExport implements FromArray, WithHeadings
{
    protected $rekap;

    public function __construct($rekap)
    {
        $this->rekap = $rekap;
    }

    public function headings(): array
    {
        return ['Nama', 'Kehadiran', 'Absent', 'Lembur', 'Keterlambatan', 'Balance'];
    }

    public function array(): array
    {
        return $this->rekap;
    }
}
