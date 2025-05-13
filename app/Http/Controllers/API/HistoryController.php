<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendanceResource;
use App\Services\API\HistoryService;

class HistoryController extends Controller
{
    protected $service;

    public function __construct(HistoryService $service) {
        $this->service = $service;
    }

    public function recent()
    {
        $result = $this->service->getTodayStatistics();

        return response()->json([
            'message' => 'Today Attendance',
            'data' => [
                'statistic' => $result['statistic'],
                'histories' => AttendanceResource::collection($result['histories'])
            ]
        ]);
    }

    public function histories()
    {

        $result = $this->service->getHistoryStatistics();

        return response()->json([
            'message' => 'Histories Attendance',
            'data' => [
                'statistic' => $result['statistic'],
                'histories' => AttendanceResource::collection($result['histories'])
            ]
        ]);
    }
}
