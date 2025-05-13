<?php

namespace App\Http\Controllers;

use App\Services\ExcuseService;

class ExcuseController extends Controller
{
    protected $service;

    public function __construct(ExcuseService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $excuses = $this->service->getAllExcuses();
        return view('excuse.app', compact('excuses'));
    }

    public function show($id)
    {
        $excuse = $this->service->getDetailExcuse($id);
        return view('excuse.detail', compact('excuse'));
    }

    public function approve($id)
    {
        $approve = $this->service->approveExcuse($id);

        if (!$approve) {
            return redirect('/excuse')->with('fail', 'Excuse approved failed');
        }

        return redirect('/excuse')->with('success', 'Excuse approved successfully');
    }

    public function cancel($id)
    {
        $this->service->cancelExcuse($id);
        return redirect('/excuse')->with('success', 'Excuse canceled');
    }
}
