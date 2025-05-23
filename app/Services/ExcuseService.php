<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Excuse;
use App\Models\SpecialHolliday;
use App\Models\WeeklyHolliday;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\File;

class ExcuseService
{
    public function getAllExcuses($filter)
    {
        $query = Excuse::query();

        if ($filter) {
            $query->where('status', $filter);
        }

        return $query->paginate(6);
    }

    public function getDetailExcuse(int $id)
    {
        return Excuse::findOrFail($id);
    }

    public function approveExcuse($start, $end, int $id)
    {
        $data = Excuse::findOrFail($id);
        $period = CarbonPeriod::create($start, $end);
        if (count(iterator_to_array($period)) > 30) {
            return [
                'success' => false,
                'message' => 'Can\'t leave over 30 days'
            ];
        }


        $data->update(['status' => 'approve']);

        foreach ($period as $date) {
            $dateString = $date->toDateString();

            $alreadyExcused = Attendance::where('user_id', $data->user_id)
                ->whereDate('date', $dateString)
                ->exists();

            $dayName = $date->format('l');
            $weeklyHoliday = WeeklyHolliday::where('day', $dayName)->first();
            $specialHoliday = SpecialHolliday::where('date', $dateString)->first();

            if (!$alreadyExcused && !$weeklyHoliday && !$specialHoliday) {
                Attendance::create([
                    'user_id' => $data->user_id,
                    'date' => $dateString,
                    'status' => 'excuse'
                ]);
            }
        }
        return [
            'success' => true,
        ];
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
