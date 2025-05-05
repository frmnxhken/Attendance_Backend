<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Excuse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $filePath = $this->saveProof($request->proof);
            Excuse::create([
                'user_id' => Auth::user()->id,
                'reason' => $request->reason,
                'proof' => $filePath,
                'date' => $request->date,
                'status' => 'pending',
            ]);
            
            return response()->json([
                'message' => 'Success create request excuse'
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'message' => $e
            ]);
        }
    }

    protected function saveProof($file)
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $folder = 'uploads/excuse';
        $destination = public_path($folder);

        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        $file->move($destination, $filename);

        return $folder . '/' . $filename;
    }
}
