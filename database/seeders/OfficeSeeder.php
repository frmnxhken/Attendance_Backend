<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Office::create([
            'name' => 'Ofc 1 Baron',
            'address' => 'Jl. Puntodewo No. 2 Baron, Nganjuk, Jawa Timur 64394',
            'long' => 112.08672,
            'lat' => -7.58994,
        ]);
    }
}
