<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ExcuseRequest;
use App\Services\API\ExcuseService;

class ExcuseController extends Controller
{
    protected $service;

    public function __construct(ExcuseService $service)
    {
        $this->service = $service;
    }

    public function requestExcuse(ExcuseRequest $request)
    {
        $this->service->createExcuse($request->all());
        return response()->json([
            'message' => 'Success create request excuse'
        ]);
    }

    public function excuses() {
        $excuses = $this->service->getExcuses();
        return response()->json([
            "message" => "Excuse Histories",
            "data" => $excuses
        ]);
    }
}