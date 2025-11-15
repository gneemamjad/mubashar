<?php

namespace App\Repository;

use App\Exceptions\CategoryNotFoundException;
use App\Models\Ad;
use App\Models\AdsReview;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\PriceHistory;
use App\Models\ReviewOption;
use Illuminate\Support\Facades\Cache;

class FilterRepository{

    function getFilterByCategory($category){
        return $category->filterAttributes;
    }   

}
