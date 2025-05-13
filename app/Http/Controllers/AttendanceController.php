<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceCombinedExport;
use App\Services\AttendanceService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    protected $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $perPage = 5;
        $currentPage = (int) $request->input('page', 1);

        $result = $this->attendanceService->getGroupedAttendances(
            $startDate, $endDate, $perPage,$currentPage);

        return view('attendance.app', [
            'attendances' => $result['attendances'],
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentPage' => $currentPage,
            'totalPages' => $result['totalPages'],
        ]);
    }

    public function resetPhoto(Request $request)
    {
        $this->attendanceService->resetPhotos();
        return redirect()->back();
    }

    public function resetAll(Request $request)
    {
        $this->attendanceService->resetAll();
        return redirect()->back();
    }

    public function exportExcel($range)
    {
        return Excel::download(new AttendanceCombinedExport($range), 'attendance-' . $range . '.xlsx');
    }
}
