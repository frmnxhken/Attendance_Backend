<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'John Doe',
                'email' => 'johndoe@example.com',
                'password' => Hash::make('password123'),
                'nip' => '123456789',
                'gender' => 'male',
                'address' => 'Jl. Example No. 1, Jakarta',
                'office_id' => 1,
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'janesmith@example.com',
                'password' => Hash::make('password123'),
                'nip' => '987654321',
                'gender' => 'female',
                'address' => 'Jl. Example No. 2, Jakarta',
                'office_id' => 2,
            ],
            [
                'name' => 'Alice Johnson',
                'email' => 'alice@example.com',
                'password' => Hash::make('password123'),
                'nip' => '123459876',
                'gender' => 'female',
                'address' => 'Jl. Example No. 3, Jakarta',
                'office_id' => 1,
            ],
            [
                'name' => 'Bob Brown',
                'email' => 'bob@example.com',
                'password' => Hash::make('password123'),
                'nip' => '223344556',
                'gender' => 'male',
                'address' => 'Jl. Example No. 4, Jakarta',
                'office_id' => 2,
            ],
            [
                'name' => 'Charlie White',
                'email' => 'charlie@example.com',
                'password' => Hash::make('password123'),
                'nip' => '334455667',
                'gender' => 'male',
                'address' => 'Jl. Example No. 5, Jakarta',
                'office_id' => 1,
            ],
            [
                'name' => 'Diana Green',
                'email' => 'diana@example.com',
                'password' => Hash::make('password123'),
                'nip' => '445566778',
                'gender' => 'female',
                'address' => 'Jl. Example No. 6, Jakarta',
                'office_id' => 2,
            ],
            [
                'name' => 'Evan Black',
                'email' => 'evan@example.com',
                'password' => Hash::make('password123'),
                'nip' => '556677889',
                'gender' => 'male',
                'address' => 'Jl. Example No. 7, Jakarta',
                'office_id' => 1,
            ],
            [
                'name' => 'Fiona Blue',
                'email' => 'fiona@example.com',
                'password' => Hash::make('password123'),
                'nip' => '667788990',
                'gender' => 'female',
                'address' => 'Jl. Example No. 8, Jakarta',
                'office_id' => 2,
            ],
            [
                'name' => 'George Red',
                'email' => 'george@example.com',
                'password' => Hash::make('password123'),
                'nip' => '778899001',
                'gender' => 'male',
                'address' => 'Jl. Example No. 9, Jakarta',
                'office_id' => 1,
            ],
            [
                'name' => 'Helen Yellow',
                'email' => 'helen@example.com',
                'password' => Hash::make('password123'),
                'nip' => '889900112',
                'gender' => 'female',
                'address' => 'Jl. Example No. 10, Jakarta',
                'office_id' => 2,
            ]
        ]);
    }
}
