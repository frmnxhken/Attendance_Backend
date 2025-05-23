<?php

namespace App\Http\Controllers;

use App\Services\ExcuseService;
use Illuminate\Http\Request;

class ExcuseController extends Controller
{
    protected $service;

    public function __construct(ExcuseService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $filter = $request->input('filter');
        $excuses = $this->service->getAllExcuses($filter);
        return view('excuse.app', compact('excuses'));
    }

    public function show($id)
    {
        $excuse = $this->service->getDetailExcuse($id);
        return view('excuse.detail', compact('excuse'));
    }

    public function approve(Request $request, $id)
    {
        $start = $request->input('start');
        $end = $request->input('end');

        $approve = $this->service->approveExcuse($start, $end, $id);

        if (!$approve['success']) {
            return redirect()->back()->with('fail', $approve['message']);
        }

        return redirect()->back()->with('success', 'Excuse approved successfully');
    }

    public function cancel($id)
    {
        $this->service->cancelExcuse($id);
        return redirect('/excuse')->with('success', 'Excuse canceled');
    }

    public function resetPhoto(Request $request)
    {
        $this->service->resetPhotos();
        return redirect()->back();
    }

    public function resetAll(Request $request)
    {
        $this->service->resetAll();
        return redirect()->back();
    }
}
