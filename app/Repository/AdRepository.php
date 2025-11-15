<?php

namespace App\Repository;

use App\Exceptions\CategoryNotFoundException;
use App\Models\Ad;
use App\Models\AdView;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\PriceHistory;
use Illuminate\Support\Facades\App;

class AdRepository
{

    public function getWithRelations()
    {
        return Ad::with(['owner', 'plans'])->select('ad.*')
        ->when(request()->has('search') && $searchValue = request('search')['value'], function($query) use ($searchValue) {
            $searchValue = strtolower($searchValue);
            $query->where(function ($q) use ($searchValue) {
                $q->whereRaw('LOWER(ad.title) LIKE ?', ["%{$searchValue}%"])
                  ->orWhereRaw('LOWER(ad.description) LIKE ?', ["%{$searchValue}%"])
                  ->orWhereRaw('ad_number LIKE ?', ["%{$searchValue}%"]);
            });
        })
        ;
    }

    public function findWithRelations($id)
    {
        return Ad::with(['owner', 'plans', 'attributes', 'media'])->where('id', $id)->first();
    }

    public function updateStatus($ad, $status)
    {
        return $ad->update(['status' => $status]);
    }

    public function toggleActive($ad)
    {
        return $ad->update(['active' => !$ad->active]);
    }

    public function togglepremium($ad)
    {
        return $ad->update(['paid' => !$ad->paid]);
    }
    public function togglesold($ad)
    {
        return $ad->update(['sold' => !$ad->sold]);
    }
    public function togglerented($ad)
    {
        return $ad->update(['rented' => !$ad->rented]);
    }
    public function togglehighlighter($ad)
    {
        return $ad->update(['highlighter' => !$ad->highlighter]);
    }

    public function delete($ad)
    {
        return $ad->delete();
    }

    public function getAdById($id)
    {
        return Ad::where('id',$id)->first();
    }

    public function findMyAd($id)
    {
        return Ad::where('user_id',auth()->user()->id)->where('id',$id)->first();
    }

    public function getAdWithOwnerById($id)
    {
        return Ad::with('owner', 'reels')->where('id',$id)->first();
    }

    public function getAdWithOwnerByAdNumber($adNumber)
    {
        return Ad::with('owner', 'reels')->where('id',$adNumber)->first();
    }

    public function getAdWithAttributesById($id)
    {
        return Ad::with('attributes')->where('id',$id)->first();
    }

    function getActiveAds($request)
    {
        $lang = request()->header('lang') ?? "en";
        $query = Ad::query()->with(['city', 'area']);
        $outsideSyria = $request->get('outside_syria');
        if($outsideSyria) {
            $this->applyOutSideSyriaFilter($query, $outsideSyria);
        } else {
            $query->active()->approved();
        }

        
        if (isset($request->filters)) {
            $this->applyFilters($query, $request->filters);
        }

        if ($request->has('category_id')) {
            $this->applyCategoryFilter($query, $request->category_id);
        }

        if ($request->has('map') && $request->map) {
            $minLat = $request->input('min_lat');
            $maxLat = $request->input('max_lat');
            $minLng = $request->input('min_lng');
            $maxLng = $request->input('max_lng');

            if ($minLat !== null && $maxLat !== null && $minLng !== null && $maxLng !== null) {
                $query->inMapSquare($minLat, $maxLat, $minLng, $maxLng);
            }
        }

        if ($request->has('sorts')) {
            switch($request->sorts){
                case 1:
                    return $query->orderByDesc('paid')->paginate(PAGINITION_PER_PAGE);
                    break;
                case 2:
                    return $query->orderByDesc('price')->paginate(PAGINITION_PER_PAGE);
                    break;
                case 3:
                    return $query->orderBy('price')->paginate(PAGINITION_PER_PAGE);
                    break;
                case 4:
                    return $query->orderBy('created_at')->paginate(PAGINITION_PER_PAGE);
                    break;
                case 5:
                    return $query->orderByDesc('created_at')->paginate(PAGINITION_PER_PAGE);
                    break;
                case 6:
                    return $query->orderByRaw("
                        CASE
                            WHEN '$lang' = 'ar' THEN
                                CASE
                                    WHEN title REGEXP '^[A-Za-z]' THEN 100
                                    WHEN title REGEXP '^[\u0600-\u06FF]' THEN 2
                                    ELSE 1

                                END
                            ELSE
                                CASE
                                    WHEN title REGEXP '^[\u0600-\u06FF]' THEN 0
                                    WHEN title REGEXP '^[A-Za-z]' THEN 20
                                    ELSE 1
                                END
                        END
                        ")
                        ->orderBy('title', 'asc')
                        ->paginate(PAGINITION_PER_PAGE);
                    break;
                case 7:
                    return $query->orderByRaw("
                        CASE
                            WHEN '$lang' = 'ar' THEN
                                CASE
                                    WHEN title REGEXP '^[A-Za-z]' THEN 3
                                    WHEN title REGEXP '^[\u0600-\u06FF]' THEN 2
                                    ELSE 1

                                END
                            ELSE
                                CASE
                                    WHEN title REGEXP '^[\u0600-\u06FF]' THEN 0
                                    WHEN title REGEXP '^[A-Za-z]' THEN 2
                                    ELSE 1
                                END
                        END
                        ")
                        ->orderBy('title', 'desc')
                        ->paginate(PAGINITION_PER_PAGE);
                        break;
                default:
                    return $query->orderByDesc('id')->paginate(PAGINITION_PER_PAGE);
                    break;
                }
        }


        return $query->orderByDesc('id')->paginate(PAGINITION_PER_PAGE);
    }

    function getActiveAdsForWeb($categoryId)
    {
        $lang = request()->header('lang') ?? "ar";
        $query = Ad::query()->with(['city', 'area']);
        
        $query->active()->approved();

        if ($categoryId) {
            $this->applyCategoryFilter($query, $categoryId);
        }


        return $query->orderByDesc('id')->paginate(PAGINITION_PER_PAGE);
    }

    function getMyDraftAds($request)
    {
        return Ad::query()->where('user_id',$request->user()->id)->where('status',Ad::STATUS['DRAFT'])->paginate(PAGINITION_PER_PAGE);
    }

    function getLastDraftAd($request)
    {
        return Ad::query()->where('user_id',$request->user()->id)->where('status',Ad::STATUS['DRAFT'])->orderByDesc('id')->first();
    }

    private function applyFilters($query, $filters)
    {
        foreach ($filters as $filter) {
            $attributeId = $filter['key'];

            switch (true) {
                case is_numeric($attributeId) && isset($filter['value']):
                    $this->applyNumericAttributeFilter($query, $attributeId, $filter['type'], $filter['value']);
                    break;
                case is_numeric($attributeId) && isset($filter['options']):
                    $this->applyOptionsAttributeFilter($query, $attributeId, $filter['options']);
                    break;
                case $attributeId == 'price':
                    $this->applyPriceFilter($query, $filter);
                case $attributeId == 'paid':
                    $this->applyPaidFilter($query, $filter);
                    break;
                case $attributeId == 'showcase':
                    $this->applyShowcaseFilter($query, $filter);
                    break;
                case $attributeId == 'owner_id':
                    $this->applyOwnerFilter($query, $filter);
                    break;
                case $attributeId == 'nearby':
                    $this->applyNearbyFilter($query, $filter);
                    break;
                case $attributeId == 'address':
                    $this->applyAddressFilter($query, $filter);
                    break;
                case $attributeId == 'keyword':
                    $this->applyKeywordFilter($query, $filter['value']);
                    break;
                case $attributeId == 'ad_date':
                    $this->applyDateFilter($query, $filter['value']);
                    break;
                case in_array($attributeId, ['vedio', '360image']):
                    $this->applyMediaFilter($query, $attributeId, $filter['value']);
                    break;
                case $attributeId == 'map':
                    $this->applyMapFilter($query, $filter['value']);
                    break;
                break;
            }
        }
    }

    private function applyNumericAttributeFilter($query, $attributeId, $type, $value)
    {

        $query->whereHas('adAttributes', function ($q) use ($attributeId, $value, $type) {

            if (!in_array($type, Attribute::TYPE)) {
                return;
            }

            if(($type == "text") || ($type == "numeric" && is_numeric($value)))
                $q->where('attribute_id', $attributeId)->where('value', $value);

            if($type == "date" && \DateTime::createFromFormat('Y-m-d', $value) !== false)
                $q->where('attribute_id', $attributeId)->whereDate('value', $value);

            if($type == "boolean" && is_bool($value))
                $q->where('attribute_id', $attributeId)->where('value', $value ? "true" : "false");

        });
    }

    private function applyOutSideSyriaFilter($query)
    {
        $query->where('status', 3);
    }

    private function applyOptionsAttributeFilter($query, $attributeId, $options)
    {
        $optionIds = collect($options)->pluck('id')->toArray();
        $query->whereHas('adAttributes', function ($q) use ($attributeId, $optionIds) {
            $q->where('attribute_id', $attributeId)
                ->whereHas('options', function ($subQ) use ($optionIds) {
                    $subQ->whereIn('ad_attribute_option_id', $optionIds);
                });
        });
    }

    private function applyPriceFilter($query, $filter)
    {
        if (isset($filter['from']))
            $query->where('price', '>=', $filter['from']);

        if (isset($filter['to']))
            $query->where('price', '<=', $filter['to']);

    }

    private function applyPaidFilter($query, $filter)
    {
        if (isset($filter['value']) == true)
            $query->where('paid', '=', 1);
    }

    private function applyShowcaseFilter($query, $filter)
    {
        if (isset($filter['value']) == true)
            $query->where('paid', '=', 1);
    }

    private function applyOwnerFilter($query, $filter)
    {
        if (isset($filter['value']))
            $query->where('user_id', '=', $filter['value']);
    }

    private function applyNearbyFilter($query, $filter)
    {
        if(isset($filter['lat']) && isset($filter['lng']) && isset($filter['from']) && isset($filter['to'])){
            $query->whereRaw("calc_distance(lat, lng, ?, ?) >= ? AND calc_distance(lat, lng, ?, ?) <= ?", [
                $filter['lat'], $filter['lng'], $filter['from'],
                $filter['lat'], $filter['lng'], $filter['to']
            ]);
        }
    }

    private function applyAddressFilter($query, $filter)
    {
        if (isset($filter['city']))
            $query->where('city_id', $filter['city']);

        if (isset($filter['area']))
            $query->where('area_id', $filter['area']);

    }

    private function applyKeywordFilter($query, $value)
    {
        $query->where(function ($q) use ($value) {
            $q->where('title', 'like', "%{$value}%")
                ->orWhere('description', 'like', "%{$value}%")
                ->orWhere('ad_number', 'like', "%{$value}%");
        });
    }

    private function applyDateFilter($query, $value)
    {
        $query->whereRaw("DATE(created_at) >= CURDATE() - INTERVAL ? DAY", [$value]);
    }

    private function applyMediaFilter($query, $type, $value)
    {
        if ($value == true) {
            $query->whereHas('media', function ($q) use ($type) {
                $q->where('type', MEDIA_TYPES[$type]);
            });
        }
    }

    private function applyMapFilter($query, $value)
    {
        if ($value == true) {
            $query->whereNotNull('lat')->whereNotNull('lng');
        }
    }

    private function applyCategoryFilter($query, $categoryId)
    {
        $category = Category::find($categoryId);
        if (!$category) {
            throw new CategoryNotFoundException();
        }
        $query->whereIn('category_id', $category->getDescendantsAndSelf()->pluck('id'));
    }

    function getAdPriceHistory($adId,$dateOfFollwing)
    {
        return PriceHistory::where('ad_id', $adId)->where('created_at','>=',$dateOfFollwing)->orderByDesc('id')->get();
    }

    function addToFaviorate($ad, $user)
    {
        return $ad->followers()->syncWithoutDetaching($user->id);
    }

    function removeFromFaviorate($ad, $user)
    {
        return $ad->followers()->detach($user->id);
    }

    function getAdsNearBy($lat, $lng, $limit)
    {
        return Ad::query()
            ->with(['city', 'area'])
            ->active()
            ->approved()
            ->selectRaw('*, calc_distance(lat, lng, ?, ?) as distance', [$lat, $lng])
            ->whereRaw('calc_distance(lat, lng, ?, ?) < 6', [$lat, $lng])
            ->orderBy('distance')
            ->limit($limit)
            ->get();
    }

    function getAdsNearByWithPagination($lat, $lng)
    {
        return Ad::query()
            ->with(['city', 'area'])
            ->active()
            ->approved()
            ->selectRaw('*, calc_distance(lat, lng, ?, ?) as distance', [$lat, $lng])
            ->whereRaw('calc_distance(lat, lng, ?, ?) < 6', [$lat, $lng])
            ->orderBy('distance')
            ->paginate(PAGINITION_PER_PAGE);
    }
    function getLastViewedAd($userId, $limit = 5)
    {
        return Ad::query()
            ->join('ad_views', 'ad.id', '=', 'ad_views.ad_id')
            ->select('ad.*')
            ->active()
            ->approved()
            ->where('ad_views.user_id', $userId)
            ->groupBy('ad.id')
            ->orderByRaw('MAX(ad_views.created_at) DESC')
            ->limit($limit)
            ->get();
    }

    function getLastViewedAdPaginated($userId)
    {
        return Ad::query()
            ->join('ad_views', 'ad.id', '=', 'ad_views.ad_id')
            ->active()
            ->approved()
            ->select('ad.*')
            ->where('ad_views.user_id', $userId)
            ->groupBy('ad.id')
            ->orderByRaw('MAX(ad_views.created_at) DESC')
            ->paginate(PAGINITION_PER_PAGE);
    }

    function getMostViewedAds($limit = 5)
    {
        return Ad::query()
            ->select('ad.*')
            ->selectRaw('COUNT(ad_views.id) as view_count')
            ->join('ad_views', 'ad.id', '=', 'ad_views.ad_id')
            ->groupBy('ad.id')
            ->orderByDesc('view_count')
            ->limit($limit)
            ->get();
    }

    function createAd($adData)
    {
        return Ad::create($adData);
    }

    function updateAd($ad, $adData)
    {
        return $ad->update($adData);
    }

    function getApprovedAdByUserId($userId)
    {
        return Ad::query()->approved()->where('user_id',$userId)->paginate(PAGINITION_PER_PAGE);
    }

    function getNotApprovedAdByUserId($userId)
    {
        return Ad::query()->notApproved()->where('user_id',$userId)->paginate(PAGINITION_PER_PAGE);
    }

    function getPendingAdByUserId($userId)
    {
        return Ad::query()->pending()->where('user_id',$userId)->paginate(PAGINITION_PER_PAGE);
    }

    function getUserAdsDetailsMetrics($userId)
    {
        return Ad::query()
        ->selectRaw("CAST(sum(if(approved = 1,1,0)) as UNSIGNED) as approved , CAST(sum(if(approved = 2,1,0)) as UNSIGNED) as not_approved , CAST(sum(if(approved = 0,1,0)) as UNSIGNED) as pending")
        ->where('user_id',$userId)
        ->first();
    }
}
