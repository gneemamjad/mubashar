<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use App\Repository\CityRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class AreaController extends Controller
{

    private $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;     
    }

    
    public function index()
    {
        $title = __('admin.sidebar.areas');
        $page = __('admin.sidebar.cities_areas_management');
        $cities =  Cache::remember('cities', 60 * 60 * 60 * 60, function () {
            return City::active()->get();
        });
        return view('admin.areas.index',compact('cities','title','page'));
    }

    public function data()
    {
        $areas = $this->cityRepository->getAreas();

        return DataTables::of($areas)
            ->addColumn('actions', function ($area) {
                return view('admin.areas.actions', compact('area'));
            })
            ->addColumn('status', function ($area) {
                return $area->active ? 'Active' : 'Inactive';
            })
            ->addColumn('city', function ($area) {
                return $area->city->name;
            })
            ->addColumn('name_ar', function ($area) {
                return $area->getTranslation('name', 'ar');
            })
            ->addColumn('name_en', function ($area) {
                return $area->getTranslation('name', 'en');
            })
            ->rawColumns(['actions', 'status'])
            ->make(true);
    }

    public function store(Request $request)
    {
        
        try{
            $request->validate([
                'name_ar' => 'required|string|max:255',
                'name_en' => 'required|string|max:255',
                'city' => 'required'
            ]);
    
            $data = [
                "name" => [
                    "en" => $request->name_en,
                    "ar" => $request->name_ar
                ],
                "city_id" => $request->city
            ];
    
            Area::create($data);
            Cache::forget('areas');

            return response()->json([
                'success' => true,
                'message' => 'Success adding area'
            ], 200);        
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Error adding area'
            ], 500);
        }
        
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'name_ar' => 'required|string|max:255',
                'name_en' => 'required|string|max:255',
                'active' => 'required',
                'city' => 'required'
            ]);
            $area = Area::findOrFail($id);

            $data = [
                "name" => [
                    "en" => $request->name_en,
                    "ar" => $request->name_ar
                ],
                "city_id" => $request->city,
                'active' => $request->active == "true" ? 1 : 0
            ];
            $area->update($data);
            Cache::forget('areas');
    
            return response()->json([
                'success' => true,
                'message' => 'Area updated successfully',
                'area' => $area
            ]);
         }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Error editing area'
            ], 500);
        }
       
    }

    public function destroy($area)
    {
        $area = Area::findOrFail($area);
        $area->delete();
        Cache::forget('areas');
        return response()->json(['message' => 'Area deleted successfully']);
    }

    public function updateStatus(Request $request, Area $area)
    {
        $area->update(['status' => $request->status]);
        return response()->json(['message' => 'Status updated successfully']);
    }
} 