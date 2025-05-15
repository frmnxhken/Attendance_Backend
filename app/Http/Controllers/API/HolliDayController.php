<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\HollidayResource;
use App\Models\SpecialHolliday;

class HolliDayController extends Controller
{
    public function index() {
        $hollidays = SpecialHolliday::all();
        return response()->json([
            'message' => 'Holliday date',
            'data' => HollidayResource::collection($hollidays) 
        ]);
    }
}
