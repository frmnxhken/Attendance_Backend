<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Attendance;
use Carbon\Carbon;
use App\Models\User;
use App\Models\WorkBalance;

class MarkAbsent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:mark-absent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark employees as absent if they haven\'t checked in or out by 16:00';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $now = Carbon::now();
        $targetTime = $now->copy()->setTime(16, 0);
        $users = User::all();
        $today = Carbon::today();

        if ($today->isWeekend()) {
            $this->info('Today is a weekend');
            return;
        }

        foreach ($users as $user) {
            $attendance = Attendance::where('user_id', $user->id)
                ->whereDate('date', $today)
                ->first();

            if (!$attendance) {
                // Mark as absent (alpha)
                $attendance = Attendance::create([
                    'user_id' => $user->id,
                    'date' => $today,
                    'status' => 'absent',
                ]);

                $balance = WorkBalance::firstOrCreate(['user_id' => $user->id], ['total_minutes' => 0]);
                $balance->total_minutes -= 480;  // 8h = 480 minutes
                $balance->save();
            } else if (is_null($attendance->checkout) && $attendance->status === 'present') {
                $attendance->update([
                    'status' => 'absent',
                ]);
                $balance = WorkBalance::firstOrCreate(['user_id' => $user->id], ['total_minutes' => 0]);
                $balance->total_minutes -= 480; 
                $balance->save();
                $this->info('Marked absent for user: ' . $user->name . ' due to missed check-in or check-out');
            }
        }

        $this->info('Absention checking up today.');
    }
}
