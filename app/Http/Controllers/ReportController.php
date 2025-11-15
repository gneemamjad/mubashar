<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\City;
use App\Services\ReportService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Ad;
use App\Models\Admin;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function usersReport(Request $request)
    {
        $filters = $request->validate([
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date',
            'version' => 'nullable|string',
            'active' => 'nullable|boolean',
            'blocked' => 'nullable|boolean',
        ]);

        return $this->reportService->generateUsersReport($filters);
    }

    public function adsReport(Request $request)
    {
        $filters = $request->validate([
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date',
            'active' => 'nullable|boolean',
            'paid' => 'nullable|boolean',
            'status' => 'nullable|string',
            'type' => 'nullable',
            'has_location' => 'nullable|boolean',
            'category' => 'nullable',
            'city' => 'nullable|exists:cities,id',
            'area' => 'nullable|exists:areas,id',
            'added_by' => 'nullable|exists:admins,id',
            'approved_by' => 'nullable|exists:admins,id',
        ]);

        return $this->reportService->generateAdsReport($filters);
    }

    public function transactionsReport(Request $request)
    {
        $filters = $request->validate([
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date',
            'payment_method' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        return $this->reportService->generateTransactionsReport($filters);
    }

    public function finicialReports()
    {
        $title = __('admin.sidebar.financial_reports');
        $page = __('admin.sidebar.reports_management');
        return view('reports.finicial',compact('title','page'));
    }

    public function adsReports()
    {
        $categories = Category::whereNotNull("parent_id")->get();
        $cities = City::all();
        $admins = Admin::all();
        $title = __('admin.sidebar.ads_reports');
        $page = __('admin.sidebar.reports_management');
        return view('reports.ads', compact('categories', 'cities', 'title', 'page', 'admins'));
    }

    public function userReports()
    {
        $title = __('admin.sidebar.users_reports');
        $page = __('admin.sidebar.reports_management');
        return view('reports.users',compact('title','page'));
    }

    public function adCharts()
    {
        $title = __('admin.sidebar.ads_charts');
        $page = __('admin.sidebar.reports_management');
        return view('admin.reports.ad-charts',compact('title','page'));
    }

    public function getAdChartsData(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start'
        ]);

        $startDate = Carbon::parse($request->start)->startOfDay();
        $endDate = Carbon::parse($request->end)->endOfDay();

        $realesateCat = Category::find(1);
        $realesatechildrenIds = $realesateCat->descendants()->pluck('id')->toArray();

        $carCat = Category::find(15);
        $carchildrenIds = $carCat->descendants()->pluck('id')->toArray();

        $realesateIdsString = implode(',', $realesatechildrenIds);
        $carIdsString = implode(',', $carchildrenIds);

        $ads = Ad::whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw("SUM(CASE WHEN approved = 1 and category_id IN ($realesateIdsString) THEN 1 ELSE 0 END) as approvedRealEstate"),
                DB::raw("SUM(CASE WHEN approved = 0 and category_id IN ($realesateIdsString) THEN 1 ELSE 0 END) as pendingRealEstate"),
                DB::raw("SUM(CASE WHEN approved = 2 and category_id IN ($realesateIdsString) THEN 1 ELSE 0 END) as rejectedRealEstate"),
                DB::raw("SUM(CASE WHEN approved = 1 and category_id IN ($carIdsString) THEN 1 ELSE 0 END) as approvedCar"),
                DB::raw("SUM(CASE WHEN approved = 0 and category_id IN ($carIdsString) THEN 1 ELSE 0 END) as pendingCar"),
                DB::raw("SUM(CASE WHEN approved = 2 and category_id IN ($carIdsString) THEN 1 ELSE 0 END) as rejectedCar")
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        $dates = [];
        $approvedRealEstate = [];
        $pendingRealEstate = [];
        $rejectedRealEstate = [];
        $approvedCar = [];
        $pendingCar = [];
        $rejectedCar = [];

        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $dateStr = $currentDate->format('Y-m-d');
            $dayData = $ads->firstWhere('date', $dateStr);

            $dates[] = $currentDate->format('M d');
            $approvedRealEstate[] = $dayData ? $dayData->approvedRealEstate : 0;
            $pendingRealEstate[] = $dayData ? $dayData->pendingRealEstate : 0;
            $rejectedRealEstate[] = $dayData ? $dayData->rejectedRealEstate : 0;
            $approvedCar[] = $dayData ? $dayData->approvedCar : 0;
            $pendingCar[] = $dayData ? $dayData->pendingCar : 0;
            $rejectedCar[] = $dayData ? $dayData->rejectedCar : 0;

            $currentDate->addDay();
        }

        return response()->json([
            'labels' => $dates,
            'approvedRealEstate' => $approvedRealEstate,
            'pendingRealEstate' => $pendingRealEstate,
            'rejectedRealEstate' => $rejectedRealEstate,
            'approvedCar' => $approvedCar,
            'pendingCar' => $pendingCar,
            'rejectedCar' => $rejectedCar
        ]);
    }

    public function getAdChartsDataApproved(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start'
        ]);

        $startDate = Carbon::parse($request->start)->startOfDay();
        $endDate = Carbon::parse($request->end)->endOfDay();

        $addedAds = Ad::whereBetween('ad.created_at', [$startDate, $endDate])
            ->whereNotNull('added_by')
            ->select(
                'added_by',
                DB::raw('COUNT(*) as count')
            )
            ->join('admins', 'ad.added_by', '=', 'admins.id')
            ->select('admins.name as name', DB::raw('COUNT(*) as count'))
            ->groupBy('added_by', 'admins.name')
            ->get();

        $approvedAds = Ad::whereBetween('ad.created_at', [$startDate, $endDate])
            ->whereNotNull('approved_by')
            ->select(
                'approved_by',
                DB::raw('COUNT(*) as count')
            )
            ->join('admins', 'ad.approved_by', '=', 'admins.id')
            ->select('admins.name as name', DB::raw('COUNT(*) as count'))
            ->groupBy('approved_by', 'admins.name')
            ->get();

        $totalAddedAds = Ad::whereBetween('ad.created_at', [$startDate, $endDate])->whereNotNull('added_by')
            ->select(
                'added_by',
                DB::raw('COUNT(*) as count')
            )
            ->select(DB::raw('COUNT(*) as count'))
            ->count();

        $totalApprovedAds = Ad::whereBetween('ad.created_at', [$startDate, $endDate])->whereNotNull('approved_by')
            ->select(
                'approved_by',
                DB::raw('COUNT(*) as count')
            )
            ->select(DB::raw('COUNT(*) as count'))
            ->count();
        return response()->json([
            'totalAddedAds' => $totalAddedAds,
            'dataAdded' => $addedAds,
            'totalApprovedAds' => $totalApprovedAds,
            'dataApproved' => $approvedAds
        ]);
    }

    public function getAdAdminData(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start'
        ]);

        $startDate = Carbon::parse($request->start)->startOfDay();
        $endDate = Carbon::parse($request->end)->endOfDay();

        $ads = Ad::whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(CASE WHEN approved = 1 THEN 1 ELSE 0 END) as approved'),
                DB::raw('SUM(CASE WHEN approved = 0 THEN 1 ELSE 0 END) as pending'),
                DB::raw('SUM(CASE WHEN approved = 2 THEN 1 ELSE 0 END) as rejected')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $dates = [];
        $approved = [];
        $pending = [];
        $rejected = [];

        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $dateStr = $currentDate->format('Y-m-d');
            $dayData = $ads->firstWhere('date', $dateStr);

            $dates[] = $currentDate->format('M d');
            $approved[] = $dayData ? $dayData->approved : 0;
            $pending[] = $dayData ? $dayData->pending : 0;
            $rejected[] = $dayData ? $dayData->rejected : 0;

            $currentDate->addDay();
        }

        return response()->json([
            'labels' => $dates,
            'approved' => $approved,
            'pending' => $pending,
            'rejected' => $rejected
        ]);
    }

    public function getCategoryChartData(Request $request)
    {
        $request->validate([
            'month_year' => 'required|date_format:Y-m'
        ]);

        $date = Carbon::createFromFormat('Y-m', $request->month_year);
        $startDate = $date->copy()->startOfMonth()->subMonths(11); // Get last 12 months
        $endDate = $date->copy()->endOfMonth();

        $rootCategories = Category::whereNull('parent_id')->limit(2)->get();
        $categoryNode1 = [];
        $categoryNode2 = [];

        foreach($rootCategories as $key => $rootCategory){
            if($key == 0){
                $categoryNode1[] = $rootCategory->getDescendants()->pluck('id');
            }else{
                $categoryNode2[] = $rootCategory->getDescendants()->pluck('id');
            }
        }

        // Initialize months array for the last 12 months
        $months = [];
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $months[] = $currentDate->format('M Y');
            $currentDate->addMonth();
        }

        // Get monthly data for both categories
        $datasets = [];

        // First Category
        $node1Data = Ad::whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('category_id', $categoryNode1[0])
            ->select(
                DB::raw('COUNT(*) as count'),
                DB::raw("DATE_FORMAT(created_at, '%b %Y') as month_year")
            )
            ->groupBy('month_year')
            ->orderBy('created_at')
            ->pluck('count', 'month_year')
            ->toArray();

        // Second Category
        $node2Data = Ad::whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('category_id', $categoryNode2[0])
            ->select(
                DB::raw('COUNT(*) as count'),
                DB::raw("DATE_FORMAT(created_at, '%b %Y') as month_year")
            )
            ->groupBy('month_year')
            ->orderBy('created_at')
            ->pluck('count', 'month_year')
            ->toArray();

        // Prepare datasets
        $datasets = [
            [
                'label' => $rootCategories[0]->name,
                'data' => array_map(function($month) use ($node1Data) {
                    return $node1Data[$month] ?? 0;
                }, $months),
                'backgroundColor' => '#e5a924',
                'borderColor' => '#07456b',
                'borderWidth' => 1
            ],
            [
                'label' => $rootCategories[1]->name,
                'data' => array_map(function($month) use ($node2Data) {
                    return $node2Data[$month] ?? 0;
                }, $months),
                'backgroundColor' => '#07456b',
                'borderColor' => '#e5a924',
                'borderWidth' => 1
            ]
        ];

        return response()->json([
            'labels' => $months,
            'datasets' => $datasets
        ]);
    }
}
