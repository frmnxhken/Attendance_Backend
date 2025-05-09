<?php

namespace Database\Seeders;

use App\Models\Excuse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExcuseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = DB::table('users')->pluck('id');
        foreach ($users as $userId) {
            Excuse::create([
                'user_id' => $userId,
                'reason' => 'Izin keperluan pribadi',
                'description' => 'Ada urusan keluarga mendesak',
                'proof' => 'proof_' . $userId . '.jpg',
                'date' => now()->format('Y-m-d'),
                'status' => 'pending',
            ]);
        }
    }
}
