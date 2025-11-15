<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function getPaymentStats()
    {
        // Get counts for approved ads
        $paidCount = Ad::where('approved', 1)
            ->where('paid', 1)
            ->count();

        $unpaidCount = Ad::where('approved', 1)
            ->where('paid', 0)
            ->count();

        return response()->json([
            'paid_count' => $paidCount,
            'unpaid_count' => $unpaidCount
        ]);
    }
}
