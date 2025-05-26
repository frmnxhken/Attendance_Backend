<?php

namespace App\Http\Controllers;

use App\Models\WorkBalance;
use Illuminate\Http\Request;

class WorkBalanceController extends Controller
{
    public function update(Request $request, $id)
    {
        $validation = $request->validate([
            'total_minutes' => 'required'
        ]);

        try {
            WorkBalance::where('user_id', $id)->update($validation);
            return redirect()->back()->with('success', 'Success updated balance');
        } catch (\Throwable $th) {
            return redirect()->back()->with('fail', 'Failed updated balance');
        }
    }
}
