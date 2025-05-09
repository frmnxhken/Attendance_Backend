<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => 'User ' . $i,
                'email' => "user{$i}@example.com",
                'email_verified_at' => now(),
                'password' => bcrypt('123'),
                'nip' => '22' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'gender' => $i % 2 === 0 ? 'male' : 'female',
                'address' => 'Alamat user ' . $i,
                'photo' => 'Image' . $i . '.jpg',
                'office_id' => 1,
            ]);
        }
    }
}
