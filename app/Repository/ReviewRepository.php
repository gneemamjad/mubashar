<?php

namespace App\Repository;

use App\Exceptions\CategoryNotFoundException;
use App\Models\Ad;
use App\Models\AdsReview;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\OwnersReview;
use App\Models\PriceHistory;
use App\Models\ReviewOption;
use Illuminate\Support\Facades\Cache;

class ReviewRepository{

    function getReviewOptions()
    {
        return Cache::remember('review-options', now()->addDays(90), function () {
            return ReviewOption::where('active',1)->get();
        });
    }

    function getReviewByOptionAndAd($ad_id,$user_id){
        return AdsReview::where('ad_id',$ad_id)->where('user_id',$user_id)->first();
    }

    function create($data)
    {
        return AdsReview::create($data);
    }

    function createOwnerReview($data)
    {
        return OwnersReview::create($data);
    }

}
