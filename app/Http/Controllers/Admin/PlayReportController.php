<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GooglePlayService;
use Illuminate\Http\Request;

class PlayReportController extends Controller
{
    public function index()
    {
        return view('admin.play_reports.index');
    }

    public function fetch(GooglePlayService $service)
    {
        $packageName = 'tr.mubashar.mubashar'; // ضع الباكيج نيم هنا

        $installs = $service->getInstalls($packageName);
        $acquisition = $service->getAcquisitionReport($packageName);

        return response()->json([
            'installs' => $installs,
            'acquisition' => $acquisition,
        ]);
    }
}
