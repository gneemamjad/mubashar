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
    public function __construct(
        private readonly AdRepository $adRepository,
        private readonly AdService $adService,
        private readonly BannerService $bannerService,
    ) {
    }

    /**
     * Render the home page ads view.
     */
    public function home(Request $request, ?int $category = null)
    {
        $categoryId = $category ?? 1;
        $request['category_id'] = $categoryId;

        try {
            $this->bannerService->getHeaderBanner($request);
            $this->bannerService->getBanners($request);

            $parentCategory = Category::findOrFail($categoryId);
            $mainCategories = $parentCategory->children;

            if ($mainCategories->isNotEmpty()) {
                $returnData = $mainCategories->map(function (Category $category) {
                    return [
                        'category' => $category,
                        'ads' => $this->retrieveAds($category, 10, false, true),
                    ];
                })->toArray();

                return view('front.ads', compact('returnData'));
            }

            $returnData = [[
                'category' => $parentCategory,
                'ads' => $this->retrieveAds($parentCategory, 50, true),
            ]];

            return view('front.ads-list', compact('returnData'));
        } catch (Exception $e) {
            Log::error('Error in get ads', ['error' => $e->getMessage()]);
            return $this->errorResponse('Server Error', ResponseCode::GENERAL_ERROR);
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


    public function ads(Request $request, $category = null)
    {
        try {
            $categoryModel = Category::find($category ?? 1);

            if (!$categoryModel) {
                abort(404, 'Category not found');
            }

            $ads = $this->adService->getAdsForWeb($categoryModel->id);

            return view('front.ads-list', [
                'ads' => $ads,
                'category' => $categoryModel,
            ]);
        } catch (Exception $e) {
            Log::error('Error in get ads', ['error' => $e->getMessage()]);
            return $this->errorResponse('Server Error', ResponseCode::GENERAL_ERROR);
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

    /**
     * Retrieve ads for a category with optional pagination.
     */
    private function retrieveAds(Category $category, int $limit, bool $paginate = false, bool $includeDescendants = false)
    {
        $categoryIds = $includeDescendants
            ? $category->getDescendantsAndSelf()->pluck('id')->toArray()
            : [$category->id];

        $query = Ad::whereIn('category_id', $categoryIds)
            ->active()
            ->approved()
            ->orderByDesc('id');

        return $paginate
            ? $query->paginate($limit)
            : $query->limit($limit)->get();
    }
}
