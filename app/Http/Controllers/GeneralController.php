<?php

namespace App\Http\Controllers;

use App\Http\Resources\API\AttributesResource;
use App\Http\Resources\API\CityResource;
use App\Http\Resources\API\CurrencyResource;
use App\Http\Resources\API\HomeSectionResource;
use App\Http\Resources\AppDetailsResource;
use App\Models\AppDetails;
use App\Models\Area;
use App\Models\Category;
use App\Models\City;
use App\Models\Currency;
use App\Models\HomeSection;
use App\Traits\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class GeneralController extends Controller
{
    function changeLanguage($lang){
        App::setLocale($lang);

        if (! in_array($lang, ['en', 'ar'])) {
            return $this->errorResponse("lang not supported",401);
        }

        return $this->successWithoutData("Lang changed");
    }

    function getHomeSections(){
        $sections = HomeSection::where('active', true)
            ->orderBy('queue')
            ->get();

        if (request()->bearerToken()) {
            $sections = $sections->filter(function ($section) {
                return !in_array($section->url, [
                    '/suggested-ads',
                    '/premium-ads'
                ]);
            })->values();
        } else {
            $sections = $sections->filter(function ($section) {
                return in_array($section->url, [
                    '/suggested-ads',
                    '/premium-ads'
                ]);
            })->values();
        }

        return $this->successWithData("Home Sections",HomeSectionResource::collection($sections));
    }

    function getCities(){

        $cities =  Cache::remember('cities', 60 * 60 * 60 * 60, function () {
            return City::active()->get();
        });
        return $this->successWithData("success",CityResource::collection($cities));
    }

    function getAreas()
    {
        $areas =  Cache::remember('areas', 60 * 60 * 60 * 60, function () {
            return Area::active()->get();
        });

        return $this->successWithData("success",CityResource::collection($areas));
    }

    function getAreasByCity($city_id)
    {
        // $areas =  Cache::remember('areas-if-city-' . $city_id, 60 * 60 * 60 * 60, function () use($city_id) {
        //     return Area::active()->where('city_id',$city_id)->get();
        // });
        $areas = Area::active()->where('city_id',$city_id)->get();
        return $this->successWithData("success",CityResource::collection($areas));

    }

    function getAppDetails($key)
    {
        $details = Cache::remember('app-details-' . $key, 60 * 60 * 60 * 60, function () use($key) {
            return AppDetails::where('key',$key)->where('active',true)->first();
        });
        return $this->successWithData("success",new AppDetailsResource($details));
    }

    function clearCache()
    {
        try {
            Cache::flush();
            return $this->successWithoutData("Cache cleared successfully");
        } catch (\Exception $e) {
            return $this->errorResponse("Failed to clear cache: " . $e->getMessage(), 500);
        }
    }

    function getCurrencies(Request $request)
    {
        $outsideSyria = $request->get('outside_syria');
        if($outsideSyria) {    
            $data = [
                'currencies' => [],
                'selected_currency' => getCurrency()
            ];
            return $this->successWithData("success",$data);
        }
        $currencies =  Cache::remember('currencies', 60 * 60 * 60 * 60, function () {
            return Currency::where('active',1)->get();
        });
        $data = [
            'currencies' => CurrencyResource::collection($currencies),
            'selected_currency' => getCurrency()
        ];
        return $this->successWithData("success",$data);
    }
}
