<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('offices')->insert([
            [
                'name' => 'Ofc 1 Baron',
                'address' => 'Baron, Nganjuk',
                'long' => 112.08672,
                'lat' => -7.58994,
                'radius' => 400
            ],
            [
                'name' => 'Ofc 2 Mastrip',
                'address' => 'Jl. Mastrip, Nganjuk',
                'long' => 112.08672,
                'lat' => -7.58994,
                'radius' => 400
            ]
        ]);
    }
}
