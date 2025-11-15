<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Resources\API\ListAdsResource;
use App\Http\Resources\API\BannerResource;
use App\Http\Resources\API\BannersResource;
use App\Services\AdService;
use App\Services\BannerService;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Helpers\ResponseCode;
use App\Models\Ad;
use App\Models\Category;
use App\Http\Resources\API\AdDetailsResource;


class PageController extends Controller
{




    protected $adService;
    protected $bannerService;

    public function __construct(AdService $adService, BannerService $bannerService)
    {
        $this->adService = $adService;
        $this->bannerService = $bannerService;
    }

    public function index(Request $request)
    {
        try {
            $ads = $this->adService->getAds($request);
            $headerBanner = $this->bannerService->getHeaderBanner($request);
            $banners = $this->bannerService->getBanners($request);
            return $this->successWithDataPagination(
                "success",
                ListAdsResource::collection($ads),
                $ads,
                [
                    'headerBanner' => $headerBanner 
                        ? new BannerResource($headerBanner) 
                        : null,
                    'banners' => $banners && $banners->count() > 0 
                        ? BannersResource::collection($banners) 
                        : [],
                ]
            );
        } catch (Exception $e) {
            Log::error('Error in get ads', ['error' => $e->getMessage()]);
            return $this->errorResponse("Server Error", ResponseCode::GENERAL_ERROR);
        }
    }


    //  public function real_estate(Request $request)
    // {
    //     // $categoryId = $request->query('category_id', 1);

    //     // $ads = $this->adService->getAds($request)->where('category_id', $categoryId);
        
    //     $ads = $this->adService->getAds($request);

    //     $real_estates = $ads;

    //     return view('web.real_estate', compact('real_estates'));

    // }

public function real_estate(Request $request)
{
    $category_id = $request->query('category_id');

    $mainCategories = \App\Models\Category::where('id', $category_id)
                        ->with('children')
                        ->get();

    $ads = $this->adService->getAds($request)->load(['category.parent.parent']);

    // التحقق إذا كان Paginator أو Collection
    if (method_exists($ads, 'getCollection')) {
        $adsGrouped = $ads->getCollection()->groupBy('category_id');
    } else {
        $adsGrouped = $ads->groupBy('category_id');
    }

    return view('web.real_estate', compact('mainCategories', 'ads', 'adsGrouped', 'category_id'));
}




    public function real_estate_show($id)
    {
        $real_estate = $this->adService->show($id);

        $city = Ad::with(['city', 'area'])->find($id);
        if (!$real_estate) {
            abort(404, 'Real Estate not found');
        }

        return view('web.real_estate_detalis', compact('real_estate'));
    }



    // public function vehicle(Request $request)
    // {
    //     try {
    //         $ads = $this->adService->getAds($request);
    //         // $ads = $ads->where('category_id', 15);
    //         $headerBanner = $this->bannerService->getHeaderBanner($request);
    //         $banners = $this->bannerService->getBanners($request);


    //         if ($request->wantsJson()) {
    //             return $this->successWithDataPagination(
    //                 "success",
    //                 ListAdsResource::collection($ads),
    //                 $ads,
    //                 [
    //                     'headerBanner' => $headerBanner 
    //                         ? new BannerResource($headerBanner) 
    //                         : null,
    //                     'banners' => $banners && $banners->count() > 0 
    //                         ? BannersResource::collection($banners) 
    //                         : [],
    //                 ]
    //             );
    //         }


    //         $vehicles_cars = $ads;

    //         return view('web.vehicles_car', compact('vehicles_cars'));

    //     } catch (Exception $e) {
    //         Log::error('Error in get ads', ['error' => $e->getMessage()]);
            
    //         if ($request->wantsJson()) {
    //             return $this->errorResponse("Server Error", ResponseCode::GENERAL_ERROR);
    //         }

    
    //         return redirect()->back()->withErrors(['error' => 'Server Error']);
    //     }
    // }


    // public function vehicle_car_show($id)
    // {
    //     $real_estate = $this->adService->show($id);

    //     $city = Ad::with(['city', 'area'])->find($id);
    //     if (!$real_estate) {
    //         abort(404, 'Real Estate not found');
    //     }

    //     return view('web.real_estate_detalis', compact('real_estate'));
    // }


}
