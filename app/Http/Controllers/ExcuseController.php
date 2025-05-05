<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExcuseController extends Controller
{
    public function index() {
        return view('excuse.app');
    }

    public function show() {
        return view('excuse.detail');
    }
}
