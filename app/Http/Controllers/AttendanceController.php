<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceCombinedExport;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;


class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $perPage = 5;
        $currentPage = (int) $request->input('page', 1);

        $attendancesQuery = Attendance::with('user')->orderBy('date', 'DESC');

        if ($startDate && $endDate) {
            $attendancesQuery->whereBetween('date', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        }

        $groupedAttendances = $attendancesQuery->get()->groupBy(function ($attendance) {
            return Carbon::parse($attendance->date)->toDateString();
        });

        $allDates = array_keys($groupedAttendances->toArray());
        $totalDates = count($allDates);
        $totalPages = ceil($totalDates / $perPage);

        $pagedDates = array_slice($allDates, ($currentPage - 1) * $perPage, $perPage);

        $pagedAttendances = collect($groupedAttendances)->only($pagedDates);

        return view('attendance.app', [
            'attendances' => $pagedAttendances,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
        ]);
    }

    public function resetPhoto(Request $request) {
        Attendance::query()->update(values: ['checkin_photo' => null, 'checkout_photo' => null]);
        File::cleanDirectory(public_path('uploads/checkin'));
        File::cleanDirectory(public_path('uploads/checkout'));
        return redirect()->back();
    }

    public function resetAll(Request $request) {
        Attendance::truncate();
        File::cleanDirectory(public_path('uploads/checkin'));
        File::cleanDirectory(public_path('uploads/checkout'));
        return redirect()->back();
    }

    public function exportExcel($range)
    {
        return Excel::download(new AttendanceCombinedExport($range), 'attendance-' . $range . '.xlsx');
    }
}
