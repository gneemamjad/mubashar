<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PlanController extends Controller
{

    public function __construct()
    {
        // Use custom permission middleware
        $this->middleware(['auth:admin', 'custom.permission:list plans,admin'])->only(['index', 'getPlans']);
        $this->middleware(['auth:admin', 'custom.permission:add plans,admin'])->only(['create', 'store']);
        $this->middleware(['auth:admin', 'custom.permission:edit plans,admin'])->only(['edit', 'update']);
        $this->middleware(['auth:admin', 'custom.permission:delete plans,admin'])->only(['destroy']);
    }

    public function index()
    {
        $title = __('admin.plans.title');
        $page = __('admin.plans.manage');
        return view('admin.plans.index',compact(['title','page']));
    }

    public function getPlans()
    {
        $plans = Plan::select(['id', 'title', 'price', 'duration_days', 'is_active', 'created_at']);

        return DataTables::of($plans)
            ->addColumn('actions', function ($plan) {
                return view('admin.plans.actions', compact('plan'));
            })
            ->editColumn('is_active', function ($plan) {
                return $plan->is_active ? 'Active' : 'Inactive';
            })
            ->editColumn('price', function ($plan) {
                return  number_format($plan->price, 2)." SYP";
            })
            ->editColumn('duration', function ($plan) {
                return $plan->duration . ' days';
            })
            ->editColumn('title', function ($plan) {
                return $plan->title;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function create()
    {
        $title = __('admin.plans.add');
        $page = __('admin.plans.manage');
        return view('admin.plans.create',compact(['title','page']));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title.en' => 'required|string|max:255',
            'title.ar' => 'required|string|max:255',
            'description.en' => 'nullable|string',
            'description.ar' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $plan = Plan::create([
            'title' => [
                'en' => $request->input('title.en'),
                'ar' => $request->input('title.ar'),
            ],
            'description' => [
                'en' => $request->input('description.en'),
                'ar' => $request->input('description.ar'),
            ],
            'price' => $request->price,
            'old_price' => $request->old_price,
            'duration_days' => $request->duration_days,
            'is_active' => true,
        ]);

        return response()->json(['success' => true, 'message' => 'Plan created successfully']);
    }

    public function edit( $plan)
    {

        $plan = Plan::find($plan);
        $title = __('admin.plans.edit');
        $page = __('admin.plans.manage');
        return view('admin.plans.edit', compact(['plan','title','page']));
    }

    public function update(Request $request, $plan)
    {

        $validator = Validator::make($request->all(), [
            'title.en' => 'required|string|max:255',
            'title.ar' => 'required|string|max:255',
            'description.en' => 'nullable|string',
            'description.ar' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'is_active' => 'required|boolean'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $plan = Plan::find($plan);
        $plan->update([
            'title' => [
                'en' => $request->input('title.en'),
                'ar' => $request->input('title.ar'),
            ],
            'description' => [
                'en' => $request->input('description.en'),
                'ar' => $request->input('description.ar'),
            ],
            'price' => $request->price,
            'old_price' => $request->old_price,
            'duration_days' => $request->duration_days,
            'is_active' => $request->is_active,
        ]);

        return response()->json(['success' => true, 'message' => 'Plan updated successfully']);
    }

    public function destroy($plan)
    {
        $plan = Plan::find($plan);
        $plan->delete();
        return response()->json(['success' => true, 'message' => 'Plan deleted successfully']);
    }
}
