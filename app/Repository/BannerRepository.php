<?php

namespace App\Repository;

use App\Exceptions\CategoryNotFoundException;
use App\Models\Ad;
use App\Models\AdView;
use App\Models\Attribute;
use App\Models\Banner;
use App\Models\Category;
use App\Models\PriceHistory;
use Illuminate\Support\Facades\App;

class BannerRepository
{
    public function getHeaderBanner($request) {
        return Banner::where('category_id', $request->category_id)->where('type', Banner::TYPES['HEADER'])->first();
    }

    public function getBanners($request) {
        return Banner::where('category_id', $request->category_id)->where('type', '!=', Banner::TYPES['HEADER'])->get();
    }
}
