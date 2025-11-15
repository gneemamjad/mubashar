<?php


namespace App\Services;

use App\Exceptions\CustomValidationException;
use App\Http\Resources\API\AdDetailsResource;
use App\Http\Resources\API\ListAdsResource;
use App\Models\Ad;
use App\Models\Attribute as ModelsAttribute;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Voucher;
use App\Repository\AdRepository;
use App\Repository\AttributesRepository;
use App\Traits\Response;
use Attribute;
use Exception;
use Hamcrest\Type\IsNumeric;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class AdService
{

    protected $adRepository;
    protected $attributesRepository;

    public function __construct(AdRepository $adRepository, AttributesRepository $attributesRepository)
    {
        $this->adRepository = $adRepository;
        $this->attributesRepository = $attributesRepository;
    }

    public function getDatatables($request)
    {
        $ads = $this->adRepository->getWithRelations();

        return DataTables::of($ads)
            ->filter(function ($query) use ($request){
                if(isset($request->status) && $request->status != "")
                    $query->where('approved',$request->status);
                if(isset($request->active) && $request->active != "")
                    $query->where('active',$request->active);
                if(isset($request->type) && $request->type != "")
                {
                    //$query->where('category_id',$request->type);
                    $category = Category::findOrFail($request->type);
                    if ($category->isLeaf()) {
                        // If it's a leaf, filter by exact category_id
                        $query->where('category_id', $category->id);
                    } else {
                        // If it's a parent, filter by all its children (including itself)
                        $query->whereIn('category_id', $category->descendantsAndSelf()->pluck('id'));
                    }
                }
                if(isset($request->category) && $request->category != "")
                    $query->whereIn('category_id',$request->category);
                if(isset($request->paid) && $request->paid != "")
                    $query->where('paid',$request->paid);
                if(isset($request->from_date) && $request->from_date != "")
                    $query->whereDate('created_at','>=',$request->from_date);
                if(isset($request->to_date) && $request->to_date != "")
                    $query->whereDate('created_at','<=',$request->to_date);
            },true)
            ->addColumn('owner', function ($ad) {
                return $ad->owner?->name . '<br><small>' . $ad->owner?->mobile . '</small>';
            })
            ->addColumn('premium_ad', function ($ad) {
                return $ad->premium == 1 ? 'premium' : '';
            })
            ->addColumn('type_name', function ($ad) {
                return $ad->getCategoryRootAttribute()?->name;
            })
            ->addColumn('category_name', function ($ad) {
                return $ad->category?->name;
            })
            ->addColumn('description_excerpt', function ($ad) {
                return \Str::limit($ad->description, 50);
            })
            ->addColumn('status_badge', function ($ad) {
                $badges = [
                    '0' => 'warning',
                    '1' => 'success',
                    '2' => 'danger'
                ];
                return '<span style="color:white;" class="badge bg-' . $badges[$ad->approved] . '">' . ($ad->approved == 1 ? 'Approved' : ( $ad->approved == 0 ? "Pending" : "Rejected" )) . '</span>';
            })
            ->addColumn('paid_badge', function ($ad) {
                if($ad->paid == 1)
                    {
                        return ' <i class="ki-filled ki-dollar text-lg">
                                </i>';
                    }
                    return "";
                // return '<span style="color:white;" class="badge bg-' . $badges[$ad->paid] . '">' . $ad->paid == 1 ? 'Paid' : 'Not Paid' . '</span>';
            })
            ->addColumn('created_at_formatted', function ($ad) {

                return $ad->created_at != null ? $ad->created_at->format('Y-m-d') : "";
            })
            ->addColumn('active_budge', function ($ad) {
                $badges = [
                    '1' => 'success',
                    '0' => 'danger'
                ];
                return '<span style="color:white;" class="badge bg-' . $badges[$ad->active] . '">' . ($ad->active == 1 ? 'Active' : "Inactive" ) . '</span>';
            })
            ->addColumn('actions', function ($ad) {
                return view('admin.ads.actions', compact('ad'));
            })
            ->rawColumns(['owner', 'status_badge', 'active_budge','actions','paid_badge'])
            ->make(true);
    }


    public function getPendingDatatables($request)
    {
        $ads = $this->adRepository->getWithRelations();

        return DataTables::of($ads)
            ->filter(function ($query) use ($request){
                $query->where('approved',Ad::STATUS['PENDING']);

                if(isset($request->active) && $request->active != "")
                    $query->where('active',$request->active);
                if(isset($request->type) && $request->type != "")
                {
                    //$query->where('category_id',$request->type);
                    $category = Category::findOrFail($request->type);
                    if ($category->isLeaf()) {
                        // If it's a leaf, filter by exact category_id
                        $query->where('category_id', $category->id);
                    } else {
                        // If it's a parent, filter by all its children (including itself)
                        $query->whereIn('category_id', $category->descendantsAndSelf()->pluck('id'));
                    }
                }
                if(isset($request->category) && $request->category != "")
                    // $query->where('category_id',$request->category);
                    $query->whereIn('category_id',$request->category);
                if(isset($request->paid) && $request->paid != "")
                    $query->where('paid',$request->paid);
                if(isset($request->from_date) && $request->from_date != "")
                    $query->whereDate('created_at','>=',$request->from_date);
                if(isset($request->to_date) && $request->to_date != "")
                    $query->whereDate('created_at','<=',$request->to_date);
            },true)
            ->addColumn('owner', function ($ad) {
                return $ad->owner?->name ?? "" . '<br><small>' . $ad->owner?->mobile ?? "" . '</small>';
            })
            ->addColumn('premium_ad', function ($ad) {
                return $ad->premium == 1 ? 'premium' : '';
            })
            ->addColumn('description_excerpt', function ($ad) {
                return \Str::limit($ad->description, 50);
            })
            ->addColumn('type_name', function ($ad) {
                return $ad->getCategoryRootAttribute()?->name ?? "";
            })
            ->addColumn('category_name', function ($ad) {
                return $ad->category?->name ?? "";
            })
            ->addColumn('status_badge', function ($ad) {
                $badges = [
                    '0' => 'warning',
                    '1' => 'success',
                    '2' => 'danger'
                ];
                return '<span style="color:white;" class="badge bg-' . $badges[$ad->approved] . '">' . ($ad->approved == 1 ? 'Approved' : ( $ad->approved == 0 ? "Pending" : "Rejected" )) . '</span>';
            })
            ->addColumn('status_badge', function ($ad) {
                $badges = [
                    '0' => 'warning',
                    '1' => 'success',
                    '2' => 'danger'
                ];
                return '<span style="color:white;" class="badge bg-' . $badges[$ad->approved] . '">' . ($ad->approved == 1 ? 'Approved' : ( $ad->approved == 0 ? "Pending" : "Rejected" )) . '</span>';
            })
            ->addColumn('paid_badge', function ($ad) {
                if($ad->paid == 1)
                    {
                        return ' <i class="ki-filled ki-magnifier">
                                </i>';
                    }
                    return "Not";
                // return '<span style="color:white;" class="badge bg-' . $badges[$ad->paid] . '">' . $ad->paid == 1 ? 'Paid' : 'Not Paid' . '</span>';
            })
            ->addColumn('created_at_formatted', function ($ad) {

                return $ad->created_at->format('Y-m-d');
            })
            ->addColumn('active_budge', function ($ad) {
                $badges = [
                    '1' => 'success',
                    '0' => 'danger'
                ];
                return '<span style="color:white;" class="badge bg-' . $badges[$ad->active] . '">' . ($ad->active == 1 ? 'Active' : "Inactive" ) . '</span>';
            })
            ->addColumn('actions', function ($ad) {
                return view('admin.ads.actions', compact('ad'));
            })
            ->rawColumns(['owner', 'status_badge', 'active_budge','actions','paid_badge'])
            ->make(true);
    }

    public function show($ad)
    {

        $ad = $this->adRepository->getAdWithOwnerById($ad);

        if(!$ad)
            return null;

        $attributes = [];
        foreach ($ad->adAttributes as $adAttribute) {
            $attribute = $this->attributesRepository->getAttribute($adAttribute->attribute_id);
            if ($attribute) {
                $attribute['value'] = $adAttribute->value;
                $attribute['attribute_options'] = "";
                if($attribute['list_type_id'] == 2) {
                    if (in_array($attribute['type'] ,["radio","select","multiselect","dropdown"])) {
                        $options = $this->attributesRepository->getAdAttributesSelectedOptions($adAttribute->id);
                        $options = $options->pluck('option')->toArray();
                        $attribute['attribute_options'] = implode(',', array_column($options, 'key_option'));
                    }
                } else {
                    if (in_array($attribute['type'] ,["radio","select","multiselect","dropdown"])) {
                        $options = $this->attributesRepository->getAdAttributesSelectedOptions($adAttribute->id);
                        $options = $options->pluck('option')->toArray();
                        $attribute['value'] = implode(',', array_column($options, 'key_option'));
                    }
                }
                $attributes[] = $attribute;
            }
            // if ($attribute) {
            //     $attribute['value'] = $adAttribute->value;
            //     $attribute['attribute_options'] = "";
            //     if (in_array($attribute['type'] ,["radio","select","multiselect"])) {
            //         $options = $this->attributesRepository->getAdAttributesSelectedOptions($adAttribute->id);
            //         $options = $options->pluck('option')->toArray();
            //         $attribute['attribute_options'] = implode(',', array_column($options, 'key_option'));
            //     }
            //     $attributes[] = $attribute;
            // }
        }

        $attributes = collect($attributes)->groupBy('typeList.type_name');
        $attributesList = [];
        foreach($attributes as $key => $list){
            $tmp = [
                "name" => $key,
                "attributes" =>  $list
            ];
            array_push($attributesList,$tmp);

        }
        $ad->setAttribute('attributes', $attributesList);
        return $ad;
    }

    public function changeStatus($ad, $status)
    {
        try {
            $result = $this->adRepository->updateStatus($ad, $status);
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function toggleActive($ad)
    {
        try {
            $ad = $this->adRepository->getAdById($ad);
            $result = $this->adRepository->toggleActive($ad);
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function togglepremium($ad)
    {
        try {
            $ad = $this->adRepository->getAdById($ad);
            $result = $this->adRepository->togglepremium($ad);
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function togglesold($ad)
    {
        try {
            $ad = $this->adRepository->getAdById($ad);
            $result = $this->adRepository->togglesold($ad);
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function togglerented($ad)
    {
        try {
            $ad = $this->adRepository->getAdById($ad);
            $result = $this->adRepository->togglerented($ad);
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function togglehighlighter($ad)
    {
        try {
            $ad = $this->adRepository->getAdById($ad);
            $result = $this->adRepository->togglehighlighter($ad);
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function destroy($ad)
    {
        try {
            $result = $this->adRepository->delete($ad);
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getAd($id)
    {
        $ad = $this->adRepository->getAdWithOwnerById($id);

        if(!$ad)
            return null;

        $ad['followed'] = false;
        $ad['reviewd'] = false;
        $ad['owner_reviewd'] = false;
        
        if (!$ad) {
            return null;
        }

        if(Auth::user()->following->contains($ad->id))
            $ad['followed'] = true;

        if(Auth::user()->reviewing->contains($ad->id))
            $ad['reviewd'] = true;

        if(Auth::user()->ownerReviewing->contains($ad->id))
            $ad['owner_reviewd'] = true;

        $attributes = [];
        foreach ($ad->adAttributes as $adAttribute) {
            $attribute = $this->attributesRepository->getAttribute($adAttribute->attribute_id);
            if ($attribute) {
                $attribute['value'] = $adAttribute->value;
                $attribute['attribute_options'] = "";
                if($attribute['list_type_id'] == 2) {
                    if (in_array($attribute['type'] ,["radio","select","multiselect","dropdown"])) {
                        $options = $this->attributesRepository->getAdAttributesSelectedOptions($adAttribute->id);
                        $options = $options->pluck('option')->toArray();
                        $attribute['attribute_options'] = implode(',', array_column($options, 'key_option'));
                    }
                } else {
                    if (in_array($attribute['type'] ,["radio","select","multiselect","dropdown"])) {
                        $options = $this->attributesRepository->getAdAttributesSelectedOptions($adAttribute->id);
                        $options = $options->pluck('option')->toArray();
                        $attribute['value'] = implode(',', array_column($options, 'key_option'));
                    }
                }
                $attributes[] = $attribute;
            }
        }

        $attributes = collect($attributes)->groupBy('typeList.type_name');
        $attributesList = [];
        foreach($attributes as $key => $list){
            $tmp = [
                "name" => $key,
                "attributes" =>  $list
            ];
            array_push($attributesList,$tmp);

        }
        $ad->setAttribute('attributes', $attributesList);
        return $ad;
    }
    public function getAdForWeb($adNumber)
    {
        $ad = $this->adRepository->getAdWithOwnerByAdNumber($adNumber);
        if(!$ad)
            return null;

        $ad['followed'] = false;
        $ad['reviewd'] = false;
        $ad['owner_reviewd'] = false;
        
        if (!$ad) {
            return null;
        }

        // if(Auth::user()->following->contains($ad->id))
            $ad['followed'] = false;

        // if(Auth::user()->reviewing->contains($ad->id))
            $ad['reviewd'] = false;

        // if(Auth::user()->ownerReviewing->contains($ad->id))
            $ad['owner_reviewd'] = false;

        $attributes = [];
        foreach ($ad->adAttributes as $adAttribute) {
            $attribute = $this->attributesRepository->getAttribute($adAttribute->attribute_id);
            if ($attribute) {
                $attribute['value'] = $adAttribute->value;
                $attribute['attribute_options'] = "";
                if($attribute['list_type_id'] == 2) {
                    if (in_array($attribute['type'] ,["radio","select","multiselect","dropdown"])) {
                        $options = $this->attributesRepository->getAdAttributesSelectedOptions($adAttribute->id);
                        $options = $options->pluck('option')->toArray();
                        $attribute['attribute_options'] = implode(',', array_column($options, 'key_option'));
                    }
                } else {
                    if (in_array($attribute['type'] ,["radio","select","multiselect","dropdown"])) {
                        $options = $this->attributesRepository->getAdAttributesSelectedOptions($adAttribute->id);
                        $options = $options->pluck('option')->toArray();
                        $attribute['value'] = implode(',', array_column($options, 'key_option'));
                    }
                }
                $attributes[] = $attribute;
            }
        }

        $attributes = collect($attributes)->groupBy('typeList.type_name');
        $attributesList = [];
        foreach($attributes as $key => $list){
            $tmp = [
                "name" => $key,
                "attributes" =>  $list
            ];
            array_push($attributesList,$tmp);

        }
        $ad->setAttribute('attributes', $attributesList);
        return $ad;
    }

    function getAds($request)
    {
        return $this->adRepository->getActiveAds($request);
    }

    function getAdsForWeb($categoryId)
    {
        return $this->adRepository->getActiveAdsForWeb($categoryId);
    }

    function getMyDraftAds($request)
    {
        return $this->adRepository->getMyDraftAds($request);
    }

    function getLastDraftAd($request)
    {
        return $this->adRepository->getLastDraftAd($request);
    }

    function getPricingHistory($adId)
    {
        $data = $this->checkIfUserIsFollower($adId);
        if(!$data)
            return false;

        $dateOfFollwing = $data->created_at;

        return [
            "dateOfFollowing" => $dateOfFollwing,
            "history" => $this->adRepository->getAdPriceHistory($adId,$dateOfFollwing)
        ];
    }

    function checkIfUserIsFollower($adId)
    {
        return Auth::user()->following()->where('ad.id',$adId)->first();
    }

    function getFavoritesList()
    {
        $ads = Auth::user()->following;
        $groupedAds = [];

        foreach ($ads as $ad) {
            $rootCategory = $ad->category->ancestorsAndSelf()->first();

            if ($rootCategory) {
                $rootCategoryGroup = $rootCategory->name;
                if (!isset($groupedAds[$rootCategoryGroup])) {
                    $groupedAds[$rootCategoryGroup] = [
                        'ads' => []
                    ];
                }
                $groupedAds[$rootCategoryGroup]['ads'][] = new ListAdsResource($ad);
            }
        }

        return $groupedAds;
    }
    function getFavoritesListWithLimit($limit)
    {
        $ads = Auth::user()->followingWithLimit($limit)->get();
        return $ads;
    }

    function getFavoritesListPaginated()
    {
        $ads = Auth::user()->following()->paginate(PAGINITION_PER_PAGE);
        return $ads;
    }

    function getLastSeenAdsByMe($limit){
        $user = Auth::user();
        if (!$user) {
            return collect();
        }
        return $this->adRepository->getLastViewedAd($user->id,$limit);
    }

    function getLastSeenAdsByMePaginated()
    {
        $user = Auth::user();
        if (!$user) {
            return collect();
        }
        return $this->adRepository->getLastViewedAdPaginated($user->id);
    }

    function getMostViewedAds($limit, $request){
        $query = Ad::query();

        $outsideSyria = $request->get('outside_syria');
        if ($outsideSyria) {
            $query->where('status', 3);
        } else {
            $query->active()->approved();    
        }
    
        $ads = $query->limit($limit)->orderByDesc('show_count')->get();
        return $ads;
    }

    function getMostViewedAdsPaginated($request)
    {
        $query = Ad::orderByDesc('show_count');

        $outsideSyria = $request->get('outside_syria');
    
        if ($outsideSyria) {
            $query->where('status', 3);
        } else {
            $query->active()->approved();    
        }
    
        $ads = $query->paginate(PAGINITION_PER_PAGE);
        
        return $ads;
    }
    
    function getSuggestedAdsPaginated($request)
    {
        $query = Ad::query();

        $outsideSyria = $request->get('outside_syria');
        if ($outsideSyria) {
            $query->where('status', 3);
        } else {
            $query->active()->approved();    
        }
    
        $ads = $query->inRandomOrder()
        ->paginate(PAGINITION_PER_PAGE);
        return $ads;
    }

    function getSuggestedAds($limit, $request)
    {
        $query = Ad::query();

        $outsideSyria = $request->get('outside_syria');
        if ($outsideSyria) {
            $query->where('status', 3);
        } else {
            $query->active()->approved();    
        }
    
        $ads = $query->inRandomOrder()->limit($limit)->get();
        return $ads;
    }

    function getPremiumAdsPaginated($request)
    {
        $query = Ad::query();

        $outsideSyria = $request->get('outside_syria');
        if ($outsideSyria) {
            $query->where('status', 3);
        } else {
            $query->active()->approved()->premium();    
        }
    
        $ads = $query->inRandomOrder()
        ->paginate(PAGINITION_PER_PAGE);
        return $ads;
    }

    function getPremiumAds($limit, $request)
    {
        $query = Ad::query();

        $outsideSyria = $request->get('outside_syria');
        if ($outsideSyria) {
            $query->where('status', 3);
        } else {
            $query->active()->approved()->premium();    
        }
    
        $ads = $query->inRandomOrder()->limit($limit)->get();
        return $ads;
    }
    
    function getShowcaseAdsPaginated($request)
    {
        $query = Ad::query();

        $outsideSyria = $request->get('outside_syria');
        if ($outsideSyria) {
            $query->where('status', 3);
        } else {
            $query->active()->approved()->showcase();    
        }
    
        $ads = $query->inRandomOrder()
        ->paginate(PAGINITION_PER_PAGE);
        return $ads;
    }

    function getShowcaseAds($limit, $request)
    {
        $query = Ad::query();

        $outsideSyria = $request->get('outside_syria');
        if ($outsideSyria) {
            $query->where('status', 3);
        } else {
            $query->active()->approved()->showcase();    
        }
    
        $ads = $query->inRandomOrder()->limit($limit)->get();
        return $ads;
    }

    function getNearByAds($lat,$lng,$limit)
    {
       $ads = $this->adRepository->getAdsNearBy($lat,$lng,$limit);
       return $ads;
    }
    function getNearByAdsWithPagination($lat,$lng)
    {
       $ads = $this->adRepository->getAdsNearByWithPagination($lat,$lng);
       return $ads;
    }

    function addToFaviorate($ad)
    {
        return $this->adRepository->addToFaviorate($ad,Auth::user());
    }

    function removeFromFaviorate($ad)
    {
        return $this->adRepository->removeFromFaviorate($ad,Auth::user());
    }


    function checkAdAttributesInRequest($data, $attributes, $throwError = true,$skipIfMissing = false)
    {
        foreach($attributes as $attribute) {
            $attributeKey = $attribute->getTranslation('key', app()->getLocale());

            if (!isset($data[$attribute->id])) {
                if ($attribute->required && !$skipIfMissing) {
                    return $this->handleValidationError($throwError, __('attributes.errors.required', ['attribute' => $attributeKey]));
                }
                continue;
            }

            // Text and textarea validation
            if(in_array($attribute->type, ['text', 'textarea'])) {
                if(empty($data[$attribute->id])) {
                    return $this->handleValidationError($throwError, __('attributes.errors.required', ['attribute' => $attributeKey]));
                }
            }

            // Boolean validation
            if($attribute->type == 'boolean') {
                if(!in_array($data[$attribute->id], ['0','1'])) {
                    return $this->handleValidationError($throwError, __('attributes.errors.boolean', ['attribute' => $attributeKey]));
                }
            }

            // Numeric validation
            if($attribute->type == 'numeric') {
                if(!is_numeric($data[$attribute->id])) {
                    return $this->handleValidationError($throwError, __('attributes.errors.numeric', ['attribute' => $attributeKey]));
                }
            }

            if($attribute->type == 'currency') {
                if(!is_array($data[$attribute->id])) {
                    return $this->handleValidationError($throwError, __('attributes.errors.array', ['attribute' => $attributeKey]));
                }

                if(!isset($data[$attribute->id]['value']) || !is_numeric($data[$attribute->id]['value'])) {
                    return $this->handleValidationError($throwError, __('attributes.errors.currency_value', ['attribute' => $attributeKey]));
                }

                if(!isset($data[$attribute->id]['currency_id']) || !in_array($data[$attribute->id]['currency_id'], array_column($attribute->currencies, 'id'))) {
                    return $this->handleValidationError($throwError, __('attributes.errors.currency_invalid', ['attribute' => $attributeKey]));
                }
            }

            // Dropdown validation
            if($attribute->type == 'select') {
                if(!in_array($data[$attribute->id], $attribute->attributeOptions->pluck('id')->toArray())) {
                    return $this->handleValidationError($throwError, __('attributes.errors.select_invalid', ['attribute' => $attributeKey]));
                }
            }

            // Date validation
            if($attribute->type == 'date') {
                if(!strtotime($data[$attribute->id])) {
                    return $this->handleValidationError($throwError, __('attributes.errors.date_invalid', ['attribute' => $attributeKey]));
                }
            }

            // Multiselect validation
            if($attribute->type == 'multiselect') {
                if(!is_array($data[$attribute->id])) {
                    return $this->handleValidationError($throwError, __('attributes.errors.array', ['attribute' => $attributeKey]));
                }

                if(empty($data[$attribute->id])) {
                    return $this->handleValidationError($throwError, __('attributes.errors.array_empty', ['attribute' => $attributeKey]));
                }

                $validOptions = $attribute->attributeOptions->pluck('id')->toArray();
                foreach($data[$attribute->id] as $option) {
                    if(!in_array($option, $validOptions)) {
                        return $this->handleValidationError($throwError, __('attributes.errors.multiselect_invalid', ['attribute' => $attributeKey]));
                    }
                }
            }

            // Radio validation
            if($attribute->type == 'radio') {
                if(!in_array($data[$attribute->id], $attribute->attributeOptions->pluck('id')->toArray())) {
                    return $this->handleValidationError($throwError, __('attributes.errors.select_invalid', ['attribute' => $attributeKey]));
                }
            }
        }
        return true;
    }

    function handleValidationError($throwError, $message)
    {
        if ($throwError)
            throw new CustomValidationException($message);
        else
            return false;
    }

    function createAd($data,$category,$attributes){
        if(isset($data["-6"])) {
            $str = $data["-6"];
            list($cityId, $areaId) = explode(',', $str);
        } else {
            $cityId = null;
            $areaId = null;
        }
        $adData = [
            'title' => $data["-1"],
            'description' => $data["-2"],
            'price' => $data["-3"]['value'],
            'currency_id' => $data["-3"]['currency_id'],
            'category_id' => $category->id,
            'user_id' => Auth::user()->id,
            'status' => Ad::STATUS['DRAFT'],
            'city_id' => $cityId,
            'area_id' => $areaId
        ];

        $ad = $this->adRepository->createAd($adData);

        foreach($attributes as $attribute){
            if($attribute->id <=0)
             continue;

             if(!isset($data[$attribute->id])){
                if($attribute->required){
                    return $this->handleValidationError(true, "Attribute ".$attribute->key." is required");
                }
                continue;
             }

            if(in_array($attribute['type'] ,[
                "boolean",
                "text",
                "numeric",
                "date",
            ])){
                $adAttribute = $ad->adAttributes()->create([
                    'attribute_id' => $attribute->id,
                    'ad_id' => $ad->id,
                    'value'=>$data[$attribute->id]
                ]);
            } elseif($attribute["type"] == "multiselect"){
                $adAttribute = $ad->adAttributes()->create([
                    'attribute_id' => $attribute->id,
                    'ad_id' => $ad->id,
                ]);
                foreach($data[$attribute->id] as $value){
                    $adAttribute->options()->create([
                        'ad_attribute_id'=>$adAttribute->id,
                        'ad_attribute_option_id'=>$value
                    ]);
                }
            }elseif(in_array($attribute["type"] ,["radio","select","dropdown"])){
                $adAttribute = $ad->adAttributes()->create([
                    'attribute_id' => $attribute->id,
                    'ad_id' => $ad->id,
                ]);
                $adAttribute->options()->create([
                    'ad_attribute_id'=>$adAttribute->id,
                    'ad_attribute_option_id'=>$data[$attribute->id]
                ]);
            }
        }
        return $ad;
    }

    function createDraftAd($adId, $data, $category, $attributes)
    {
        $ad = Ad::findOrFail($adId);

        if (isset($data["-6"])) {
            [$cityId, $areaId] = explode(',', $data["-6"]);
        } else {
            $cityId = null;
            $areaId = null;
        }

        $adData = [
            'title' => $data["-1"],
            'description' => $data["-2"],
            'price' => $data["-3"]['value'],
            'currency_id' => $data["-3"]['currency_id'],
            'category_id' => $category->id,
            'city_id' => $cityId,
            'area_id' => $areaId,
        ];

        $ad->update($adData);

        // Remove old ad attributes (to reset options/values)
        $ad->adAttributes()->each(function ($attr) {
            $attr->options()->delete(); // delete multiselect/select options
            $attr->delete();
        });

        // Re-attach attributes like in create
        foreach ($attributes as $attribute) {
            if ($attribute->id <= 0) continue;

            if (!isset($data[$attribute->id])) {
                if ($attribute->required) {
                    return $this->handleValidationError(true, "Attribute " . $attribute->key . " is required");
                }
                continue;
            }

            if (in_array($attribute['type'], ["boolean", "text", "numeric", "date"])) {
                $ad->adAttributes()->create([
                    'attribute_id' => $attribute->id,
                    'ad_id' => $ad->id,
                    'value' => $data[$attribute->id]
                ]);
            } elseif ($attribute["type"] == "multiselect") {
                $adAttribute = $ad->adAttributes()->create([
                    'attribute_id' => $attribute->id,
                    'ad_id' => $ad->id,
                ]);
                foreach ($data[$attribute->id] as $value) {
                    $adAttribute->options()->create([
                        'ad_attribute_option_id' => $value
                    ]);
                }
            } elseif (in_array($attribute["type"], ["radio", "select", "dropdown"])) {
                $adAttribute = $ad->adAttributes()->create([
                    'attribute_id' => $attribute->id,
                    'ad_id' => $ad->id,
                ]);
                $adAttribute->options()->create([
                    'ad_attribute_option_id' => $data[$attribute->id]
                ]);
            }
        }

        return $ad;
    }

    
    function updateAd($ad, $data) {
        $mapping = [
            '-1' => 'title',
            '-2' => 'description',
            '-4' => 'sold',
            '-5' => 'rented'
        ];
    
        $adData = [];
    
        // Map simple fields
        foreach ($mapping as $key => $field) {
            if (isset($data[$key])) {
                $adData[$field] = $data[$key];
            }
        }
    
        // Handle nested price and currency_id
        if (isset($data["-3"])) {
            if (isset($data["-3"]['value'])) {
                $adData['price'] = $data["-3"]['value'];
            }
    
            if (isset($data["-3"]['currency_id'])) {
                $adData['currency_id'] = $data["-3"]['currency_id'];
            }
        }

        if (isset($data["-6"])) {
            list($cityId, $areaId) = explode(',', $data["-6"]);
            $adData['city_id'] = $cityId;
            $adData['area_id'] = $areaId;
        }
        $this->adRepository->updateAd($ad, $adData);
    }

    
    function createAdFromAdmin($data){
        $adData = [
            'title' => $data["title"],
            'description' => $data["description"],
            'price' => $data["price"],
            'currency_id' => array_search($data["selectedCurrency"], Currency::CURRENCY),
            'category_id' => $data["category"],
            'user_id' => $data["selectedUser"],
            'status' => Ad::STATUS['APPROVED'],
            'verified_at' => now(),
            'lat' => $data["latitude"],
            'lng' => $data["longitude"],
            'city_id' => $data['city_id'],
            'area_id' => $data['area_id'],
            'added_by' => Auth::user()->id
        ];

        $ad = $this->adRepository->createAd($adData);
        foreach($data['staticAttributeData'] as $key => $val){
            $attr = ModelsAttribute::find($key);
            if(in_array($attr['type'] ,[
                "boolean",
                "text",
                "numeric",
                "date",
            ])){
                $adAttribute = $ad->adAttributes()->create([
                    'attribute_id' => $attr['id'],
                    'ad_id' => $ad->id,
                    'value'=>$val
                ]);
            }elseif($attr["type"] == "multiselect"){
                $adAttribute = $ad->adAttributes()->create([
                    'attribute_id' => $attr['id'],
                    'ad_id' => $ad->id,
                ]);
                foreach($val as $value){
                    $adAttribute->options()->create([
                        'ad_attribute_id'=>$adAttribute->id,
                        'ad_attribute_option_id'=>$value
                    ]);
                }
            }elseif(in_array($attr["type"] ,["radio","select","dropdown"])){
                $adAttribute = $ad->adAttributes()->create([
                    'attribute_id' => $attr['id'],
                    'ad_id' => $ad->id,
                ]);
                $adAttribute->options()->create([
                    'ad_attribute_id'=>$adAttribute->id,
                    'ad_attribute_option_id'=>$val
                ]);
            }
        }
        foreach($data['featuredAttributeData'] as $key => $val){
            $attr = ModelsAttribute::find($key);
            if(in_array($attr['type'] ,[
                "boolean",
                "text",
                "numeric",
                "date",
            ])){
                $adAttribute = $ad->adAttributes()->create([
                    'attribute_id' => $attr['id'],
                    'ad_id' => $ad->id,
                    'value'=>$val
                ]);
            }elseif($attr["type"] == "multiselect"){
                $adAttribute = $ad->adAttributes()->create([
                    'attribute_id' => $attr['id'],
                    'ad_id' => $ad->id,
                ]);
                foreach($val as $value){
                    $adAttribute->options()->create([
                        'ad_attribute_id'=>$adAttribute->id,
                        'ad_attribute_option_id'=>$value
                    ]);
                }
            }elseif(in_array($attr["type"] ,["radio","select","dropdown"])){
                $adAttribute = $ad->adAttributes()->create([
                    'attribute_id' => $attr['id'],
                    'ad_id' => $ad->id,
                ]);
                $adAttribute->options()->create([
                    'ad_attribute_id'=>$adAttribute->id,
                    'ad_attribute_option_id'=>$val
                ]);
            }
        }
        return $ad;

    }
    function updateAdFromAdmin($id, $data){
        $adData = [
            'title' => $data["title"],
            'description' => $data["description"],
            'price' => $data["price"],
            'currency_id' => array_search($data["selectedCurrency"], Currency::CURRENCY),
            'category_id' => $data["category"],
            'user_id' => $data["selectedUser"],
            'status' => Ad::STATUS['APPROVED'],
            'verified_at' => now(),
            'lat' => $data["latitude"],
            'lng' => $data["longitude"],
            'city_id' => $data['city_id'],
            'area_id' => $data['area_id'],
            'added_by' => Auth::user()->id
        ];
        $existAd = Ad::with('attributes', 'adAttributes.options')->find($id);

        $ad = $this->adRepository->updateAd($existAd, $adData);
        foreach ($existAd->adAttributes as $adAttribute) {            
            if($adAttribute->required){
                return "Attribute ".$adAttribute->key." is required";
            }
            continue;
        }
        foreach ($existAd->adAttributes as $adAttribute) {
            $adAttribute->options()->delete();
        }

        $existAd->adAttributes()->delete();

        foreach($data['staticAttributeData'] as $key => $val){
            $attr = ModelsAttribute::find($key);
            if(in_array($attr['type'] ,[
                "boolean",
                "text",
                "numeric",
                "date",
            ])){
                $adAttribute = $existAd->adAttributes()->create([
                    'attribute_id' => $attr['id'],
                    'ad_id' => $existAd->id,
                    'value'=>$val
                ]);
            }elseif($attr["type"] == "multiselect"){
                $adAttribute = $existAd->adAttributes()->create([
                    'attribute_id' => $attr['id'],
                    'ad_id' => $existAd->id,
                ]);
                foreach($val as $value){
                    $adAttribute->options()->create([
                        'ad_attribute_id'=>$adAttribute->id,
                        'ad_attribute_option_id'=>$value
                    ]);
                }
            }elseif(in_array($attr["type"] ,["radio","select","dropdown"])){
                $adAttribute = $existAd->adAttributes()->create([
                    'attribute_id' => $attr['id'],
                    'ad_id' => $existAd->id,
                ]);
                $adAttribute->options()->create([
                    'ad_attribute_id'=>$adAttribute->id,
                    'ad_attribute_option_id'=>$val
                ]);
            }
        }
        foreach($data['featuredAttributeData'] as $key => $val){
            $attr = ModelsAttribute::find($key);
            if(in_array($attr['type'] ,[
                "boolean",
                "text",
                "numeric",
                "date",
            ])){
                $adAttribute = $existAd->adAttributes()->create([
                    'attribute_id' => $attr['id'],
                    'ad_id' => $existAd->id,
                    'value'=>$val
                ]);
            }elseif($attr["type"] == "multiselect"){
                $adAttribute = $existAd->adAttributes()->create([
                    'attribute_id' => $attr['id'],
                    'ad_id' => $existAd->id,
                ]);
                foreach($val as $value){
                    if(isset($value)) {
                        $adAttribute->options()->create([
                            'ad_attribute_id'=>$adAttribute->id,
                            'ad_attribute_option_id'=>$value
                        ]);
                    }
                }
            }elseif(in_array($attr["type"] ,["radio","select","dropdown"])){
                $adAttribute = $existAd->adAttributes()->create([
                    'attribute_id' => $attr['id'],
                    'ad_id' => $existAd->id,
                ]);
                $adAttribute->options()->create([
                    'ad_attribute_id'=>$adAttribute->id,
                    'ad_attribute_option_id'=>$val
                ]);
            }
        }
        return $existAd;

    }

    function addStaticAttributes($data,$ad,$attributes){

        foreach($attributes as $attribute){
            if($attribute->id <=0)
             continue;

             if(!isset($data[$attribute->id])){
                if($attribute->required){
                    return $this->handleValidationError(true, "Attribute ".$attribute->key." is required");
                }
                continue;
             }

            if(in_array($attribute['type'] ,[
                "boolean",
                "text",
                "numeric",
                "date",
            ])){
                $adAttribute = $ad->adAttributes()->create([
                    'attribute_id' => $attribute->id,
                    'ad_id' => $ad->id,
                    'value'=>$data[$attribute->id]
                ]);
            }elseif($attribute["type"] == "multiselect"){
                $adAttribute = $ad->adAttributes()->create([
                    'attribute_id' => $attribute->id,
                    'ad_id' => $ad->id,
                ]);
                foreach($data[$attribute->id] as $value){
                    $adAttribute->options()->create([
                        'ad_attribute_id'=>$adAttribute->id,
                        'ad_attribute_option_id'=>$value
                    ]);
                }
            }elseif(in_array($attribute["type"] ,["radio","select","dropdown"])){
                $adAttribute = $ad->adAttributes()->create([
                    'attribute_id' => $attribute->id,
                    'ad_id' => $ad->id,
                ]);
                $adAttribute->options()->create([
                    'ad_attribute_id'=>$adAttribute->id,
                    // 'ad_attribute_option_id'=>$data[$attribute->id]
                    'ad_attribute_option_id'=>$data[$attribute->id][0]
                ]);
            }
        }
        return $ad;

    }

    function addFeaturedAttributes($data,$ad,$attributes){

        foreach($attributes as $attribute){
            if($attribute->id <=0)
             continue;

             if(!isset($data[$attribute->id])){
                if($attribute->required){
                    return $this->handleValidationError(true, "Attribute ".$attribute->key." is required");
                }
                continue;
             }

            if(in_array($attribute['type'] ,[
                "boolean",
                "text",
                "numeric",
                "date",
            ])){
                $adAttribute = $ad->adAttributes()->create([
                    'attribute_id' => $attribute->id,
                    'ad_id' => $ad->id,
                    'value'=>$data[$attribute->id]
                ]);
            }elseif($attribute["type"] == "multiselect"){
                $adAttribute = $ad->adAttributes()->create([
                    'attribute_id' => $attribute->id,
                    'ad_id' => $ad->id,
                ]);
                foreach($data[$attribute->id] as $value){
                    $adAttribute->options()->create([
                        'ad_attribute_id'=>$adAttribute->id,
                        'ad_attribute_option_id'=>$value
                    ]);
                }
            }elseif(in_array($attribute["type"] ,["radio","select","dropdown"])){
                $adAttribute = $ad->adAttributes()->create([
                    'attribute_id' => $attribute->id,
                    'ad_id' => $ad->id,
                ]);
                $adAttribute->options()->create([
                    'ad_attribute_id'=>$adAttribute->id,
                    // 'ad_attribute_option_id'=>$data[$attribute->id]
                    'ad_attribute_option_id'=>$data[$attribute->id][0]
                ]);
            }
        }
        return $ad;

    }

    function getAdsByUser($request,$userId)
    {
        switch($request->type){
            case Ad::STATUS['APPROVED']:
                return $this->adRepository->getApprovedAdByUserId($userId);
            case Ad::STATUS['NOT_APPROVED']:
                return $this->adRepository->getNotApprovedAdByUserId($userId);
            case Ad::STATUS['PENDING']:
                return $this->adRepository->getPendingAdByUserId($userId);
            default:
                return [];
        }

        return [];
    }

}
