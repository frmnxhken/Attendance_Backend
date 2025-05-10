<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Excuse;
use App\Models\Attendance;
use Carbon\Carbon;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $users = User::orderBy('name')->get();
        $excuses = Excuse::where('status', 'pending')->get();
        $late = Attendance::where('checkin', '>', Carbon::today()->setTime(8, 0, 0))->get();
        return view('dashboard.app', compact('users', 'excuses','late'));
    }
}


