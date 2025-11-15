<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\PlanResource;
use App\Models\Plan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index(): JsonResponse
    {
        $plans = Plan::where('is_active', true)->get();

        return response()->json([
            'status' => true,
            'message' => 'Plans retrieved successfully',
            'data' => PlanResource::collection($plans)
        ]);
    }

    public function show(Plan $plan): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => 'Plan retrieved successfully',
            'data' => new PlanResource($plan)
        ]);
    }
}
