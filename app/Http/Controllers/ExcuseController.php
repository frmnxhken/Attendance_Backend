<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Excuse;
use Carbon\Carbon;

class ExcuseController extends Controller
{
    public function index() {
        $excuses = Excuse::all();
        return view('excuse.app', compact('excuses'));
    }

    public function show($id) {
        $excuse = Excuse::findOrFail($id);
        return view('excuse.detail', compact('excuse'));
    }

    public function approve($id) {
        $today = Carbon::today()->format('Y-m-d');
        $data = Excuse::findOrFail($id);
        $data->update(['status' => 'approve']);

        Attendance::create([
            'user_id' => $data->user_id,
            'date' => $today,
            'status' => 'Excuse'
        ]);

        return redirect('/excuse')->with('success', 'Excuse approved successfully');
    }

    public function cancel($id) {
        $data = Excuse::findOrFail($id);
        $data->update(['status' => 'cancel']);
        return redirect('/excuse')->with('success', 'Excuse canceled');
    }
}
