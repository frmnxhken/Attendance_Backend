<?php

namespace App\Http\Controllers;
use App\Models\Excuse;

use Illuminate\Http\Request;

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
        $data = Excuse::findOrFail($id);
        $data->update(['status' => 'approve']);
        return redirect('/excuse')->with('success', 'Excuse approved successfully');
    }

    public function cancel($id) {
        $data = Excuse::findOrFail($id);
        $data->update(['status' => 'cancel']);
        return redirect('/excuse')->with('success', 'Excuse canceled');
    }
}
