<?php

namespace App\Services;

use App\Models\User;
use App\Models\Office;
use App\Models\Attendance;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getAllUsersWithOffices()
    {
        return User::with('office')->paginate(7);
    }

    public function getAllOffices()
    {
        return Office::all();
    }

    public function createUser(array $data): bool
    {
        $data['password'] = Hash::make($data['nip']);
        User::create($data);
        return true;
    }

    public function getUserDetailWithAttendance(string $id): array
    {
        $attendance = Attendance::where('user_id', $id)->get();
        $user = User::findOrFail($id);

        $statistic = [
            'present' => $attendance->where('status', 'present')->count(),
            'late' => $attendance->where('status', 'present')->where('late_minutes', '>', 0)->count(),
            'excused' => $attendance->where('status', 'excuse')->count(),
            'absent' => $attendance->where('status', 'absent')->count()
        ];

        return compact('user', 'statistic');
    }

    public function getUserWithOffice(string $id)
    {
        return User::with('office')->findOrFail($id);
    }

    public function updateUser(string $id, array $data): bool
    {
        User::findOrFail($id)->update($data);
        return true;
    }

    public function deleteUser(string $id): bool
    {
        $user = User::findOrFail($id);

        if ($user->photo && file_exists(public_path("employee/{$user->photo}"))) {
            @unlink(public_path("employee/{$user->photo}"));
        }

        $user->delete();
        return true;
    }
}
