<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Excuse;
use Carbon\Carbon;

class ExcuseService
{
    public function getAllExcuses()
    {
        return Excuse::all();
    }

    public function getDetailExcuse(int $id)
    {
        return Excuse::findOrFail($id);
    }

    public function approveExcuse(int $id)
    {
        $today = Carbon::today()->toDateString();
        $data = Excuse::findOrFail($id);
        $data->update(['status' => 'approve']);

        $alreadyExcused = Attendance::where('user_id', $data->user_id)
            ->whereDate('date', $today)
            ->exists();

        if (!$alreadyExcused) {
            Attendance::create([
                'user_id' => $data->user_id,
                'date' => $today,
                'status' => 'excuse'
            ]);
        }

        return true;
    }

    public function cancelExcuse(int $id)
    {
        $data = Excuse::findOrFail($id);
        $data->update(['status' => 'cancel']);
        return true;
    }
}
