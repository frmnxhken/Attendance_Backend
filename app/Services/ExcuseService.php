<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Excuse;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class ExcuseService
{
    public function getAllExcuses($filter)
    {
        $query = Excuse::query();

        if ($filter) {
            $query->where('status', $filter);
        }

        return $query->paginate(1);
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

    public function resetPhotos(): void
    {
        Excuse::query()->update(['proof' => null]);
        File::cleanDirectory(public_path('uploads/excuse'));
    }
    
    public function resetAll(): void
    {
        Excuse::truncate();
        File::cleanDirectory(public_path('uploads/excuse'));
    }
}
