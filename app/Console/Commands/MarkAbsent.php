<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AttendanceService;

class MarkAbsent extends Command
{
    protected $signature = 'attendance:check';
    protected $description = 'Check daily attendance and mark absent if needed';

    protected $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        parent::__construct();
        $this->attendanceService = $attendanceService;
    }

    public function handle()
    {
        $this->info('Running daily attendance check...');

        $result = $this->attendanceService->checkUpToday();

        if (isset($result['warning'])) {
            $this->warn($result['warning']);
        }

        if (isset($result['success'])) {
            $this->info($result['success']);
        }

        $this->info('Attendance check completed.');
    }
}
