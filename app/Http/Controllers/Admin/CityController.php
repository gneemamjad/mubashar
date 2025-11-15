<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Repository\CityRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{

    private $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }


    public function index()
    {
        $title = __('admin.sidebar.cities');
        $page = __('admin.sidebar.cities_areas_management');
        $cities = City::latest()->get();
        return view('admin.cities.index', compact('cities', 'title', 'page'));
    }

    public function create()
    {
        return view('admin.cities.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $city = $this->cityRepository->create([
                'name' => [
                    'en' => $request->name_en,
                    'ar' => $request->name_ar,
                ]
            ]);
            Cache::forget('cities');

            return response()->json([
                'success' => true,
                'message' => 'City added successfully',
                'city' => $city
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding city'
            ], 500);
        }
    }

    public function edit(City $city)
    {
        return view('admin.cities.edit', compact('city'));
    }

    public function update(Request $request,$id)
    {
        try{
            $request->validate([
                'name_en' => 'required|string|max:255',
                'name_ar' => 'required|string|max:255',
                'active' => 'required'
            ]);
            $city = City::findOrFail($id);

            $data = [
                "name" => [
                    "ar" => $request->name_ar,
                    "en" => $request->name_en,

                ],
                "active" => $request->active == "true" ? 1 : 0
            ];
            $city->update($data);

            Cache::forget('cities');

            return response()->json([
                'success' => true,
                'message' => 'City updated successfully',
                'city' => $city
            ]);

        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Error updating city'
            ], 500);
        }
    }

    public function destroy($city)
    {
        $city = City::findOrFail($city);
        $city->delete();
        Cache::forget('cities');

        return redirect()->route('admin.cities.index')
            ->with('success', 'City deleted successfully.');
    }

    public function toggleStatus(City $city)
    {
        $city->update(['is_active' => !$city->is_active]);
        return response()->json(['success' => true]);
    }

    public function data()
    {
        $cities = $this->cityRepository->get();

        return datatables()->of($cities)
            ->addColumn('actions', function ($city) {
                return view('admin.cities.actions', compact('city'));
            })

            ->addColumn('status', function ($city) {
                return $city->active ? 'Active' : 'Inactive';
            })
            ->addColumn('name_ar', function ($city) {
                return $city->getTranslation('name', 'ar');
            })
            ->addColumn('name_en', function ($city) {
                return $city->getTranslation('name', 'en');
            })
            ->rawColumns(['actions', 'status'])
            ->make(true);
    }
}
