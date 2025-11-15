<?php

namespace App\Repository;

use App\Models\Area;
use App\Models\City;
use App\Models\Currency;
use App\Models\ExchangeCurrency;
use Illuminate\Support\Facades\Cache;

class CityRepository
{

    public function get()
    {
      return City::select('city.*')   
        ->when(request()->has('search') && $searchValue = request('search')['value'], function($query) use ($searchValue) {
            $searchValue = strtolower($searchValue);
            $query->where(function ($q) use ($searchValue) {
                $q->whereRaw('LOWER(city.name) LIKE ?', ["%{$searchValue}%"]);             
            });
        });
    }

    function getAreas()
    {
        return Area::select('area.*')   
        ->when(request()->has('search') && $searchValue = request('search')['value'], function($query) use ($searchValue) {
            $searchValue = strtolower($searchValue);
            $query->where(function ($q) use ($searchValue) {
                $q->whereRaw('LOWER(area.name) LIKE ?', ["%{$searchValue}%"]);             
            });
        });    
    }
   
    public function create(array $data)
    {
        return City::create([
            'name' => $data['name']
        ]);
    }
} 