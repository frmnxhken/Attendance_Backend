<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = DB::table('users')->pluck('id');
        $dates = [];
        $startDate = Carbon::createFromDate(2025, 5, 1); // Mulai dari 1 Mei 2025
        $endDate = Carbon::createFromDate(2025, 5, 14); // Sampai 30 Juni 2025
        $status = ['absent', 'present'];
        
        while ($startDate <= $endDate) {
            $dates[] = $startDate->format('Y-m-d');
            $startDate->addDay(); 
        }

        foreach ($users as $userId) {
            foreach ($dates as $date) {
                DB::table('attendances')->insert([
                    'user_id' => $userId,
                    'date' => $date,
                    'checkin' => '08:00:00',
                    'checkin_long' => 106.8456,
                    'checkin_lat' => -6.2088,
                    'checkin_distance' => 200,
                    'checkin_photo' => 'checkin_photo_' . $userId . '.jpg',
                    'checkout' => '17:00:00',
                    'checkout_long' => 106.8457,
                    'checkout_lat' => -6.2090,
                    'checkout_distance' => 300,
                    'checkout_photo' => 'checkout_photo_' . $userId . '.jpg',
                    'late_minutes' => rand(0, 1), // Random late minutes (0-30 minutes)
                    'early_leave' => rand(0, 10), // Random early leave (0-10 minutes)
                    'extra_minutes' => rand(0, 120), // Random extra minutes (0-120 minutes)
                    'status' => $status[array_rand($status, 1)] // Change this based on status if needed
                ]);
            }
        }
    }
}
