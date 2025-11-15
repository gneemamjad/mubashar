<?php

namespace App\Http\Controllers\Front;

use App\Helpers\ResponseCode;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\BannerResource;
use App\Http\Resources\API\BannersResource;
use App\Http\Resources\API\ListAdsResource;
use App\Models\Ad;
use App\Models\Category;
use App\Repository\AdRepository;
use App\Services\AdService;
use App\Services\BannerService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdController extends Controller
{
    protected $adRepository;
    protected $adService;
    protected $bannerService;
    protected $attributeService;

    public function __construct(
            AdRepository $adRepository,
            AdService $adService,
            BannerService $bannerService
    )
    {
        $this->adRepository = $adRepository;
        $this->adService = $adService;
        $this->bannerService = $bannerService;
    }
    public function home(Request $request, $category = null)
    {
        $category = $category ?? 1;
        $request['category_id'] = $category;

        try {
            $headerBanner = $this->bannerService->getHeaderBanner($request);
            $banners = $this->bannerService->getBanners($request);

            $parentCategory = Category::findOrFail($category);

            $mainCategories = $parentCategory->children;
            $returnData = [];
            if(count($mainCategories) > 0) {    
                foreach ($mainCategories as $mainCategory) {

                    $allCategoryIds = $mainCategory
                        ->getDescendantsAndSelf()
                        ->pluck('id')
                        ->toArray();
                    $ads = Ad::whereIn('category_id', $allCategoryIds)->active()->approved()->orderBy('id','desc')->limit(10)->get();

                    
                    $returnData[] = [
                        'category' => $mainCategory,
                        'ads'      => $ads,
                    ];
                }
                return view('front.ads', compact('returnData'));
            } else {
                $ads = Ad::where('category_id', $parentCategory->id)->active()->approved()->orderBy('id','desc')->paginate(50);
                $returnData[] = [
                    'category' => $parentCategory,
                    'ads'      => $ads,
                ];
                return view('front.ads-list', compact('returnData'));
            }

        } catch (Exception $e) {
            Log::error('Error in get ads', ['error' => $e->getMessage()]);
            return $this->errorResponse("Server Error", ResponseCode::GENERAL_ERROR);
        }
    }
    public function loadMoreAds(Request $request)
    {
        $page = $request->page ?? 1;
        $category = $request->category_id;

        $ads = Ad::where('category_id', $category)
            ->active()->approved()
            ->orderBy('id', 'desc')
            ->paginate(50, ['*'], 'page', $page);

        $view = view('components.ads-list', compact('ads'))->render();

        return response()->json([
            'html' => $view,
            'hasMore' => $ads->hasMorePages(),
        ]);
    }


    public function ads(Request $request, $category = null) {
        try {
            if(isset($category)) {
                $category = Category::find($category);
            } else {
                $category = Category::find(1);
            }
            $ads = $this->adService->getAdsForWeb($category->id);
            return view('front.ads-list', compact('ads', 'category'));
        } catch (Exception $e) {
            Log::error('Error in get ads', ['error' => $e->getMessage()]);
            return $this->errorResponse("Server Error", ResponseCode::GENERAL_ERROR);
        }
    }

    public function show(string $ad_number, Request $request)
    {
        // try{
            $ad = $this->adService->getAdForWeb($ad_number);
            if(!$ad)
                return "Not Found";

            // $ad->increment('show_count');
            // // Save user view if authenticated
            // if (Auth::check()) {
            //     $ad->views()->attach(Auth::id(), [
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //     ]);
            // }
            return view('front.ad-details', compact('ad'));
        // }
        // catch(Exception $e){
        //     return $this->errorResponse("Server Error",ResponseCode::GENERAL_ERROR);
        // }

    }
}
