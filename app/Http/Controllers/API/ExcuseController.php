<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Excuse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExcuseController extends Controller
{
    public function requestExcuse(Request $request) {
        $validation = Validator::make($request->all(),[
            'reason' => 'required',
            'proof' => 'required',
            'date' => 'required'
        ]);

        if($validation->fails()) {
            return response()->json([
                'message' => $validation->errors()
            ]);
        }

        try {
            Excuse::create([
                'reason' => $request->reason,
                'proof' => $request->proof,
                'date' => $request->date,
                'status' => 'pending',
            ]);
            
            return response()->json([]);
        } catch (\Throwable $th) {
            //throw $th;
        }

    }
}
