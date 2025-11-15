<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Bank;
use App\Models\Category;
use App\Models\Currency;
use App\Models\DraftTransaction;
use App\Models\User;
use App\Models\AdsReview;
use App\Models\City;
use App\Models\Media;
use App\Repository\AdRepository;
use App\Services\AdService;
use App\Services\AttributeService;
use App\Services\PayPal\PayPalService;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use App\Helpers\ResponseCode;

class AdController extends Controller
{
    protected $adService;
    protected $adRepository;
    protected $payPalService;
    protected $stripeService;
    protected $attributeService;
    
    public function __construct(PayPalService $payPalService, StripeService $stripeService, AdService $adService, AdRepository $adRepository, AttributeService $attributeService)
    {
        $this->adService = $adService;
        $this->adRepository = $adRepository;
        $this->payPalService = $payPalService;
        $this->stripeService = $stripeService;
        $this->attributeService = $attributeService;
    }

    public function searchAjax(Request $request) {

        $query = $request->get('q');

        $users = Ad::query()
            ->where(function($q) use ($query) {
                $q->where('ad_number', 'like', '%' . $query . '%')
                ->orWhere('title', 'like', '%' . $query . '%');
            })
            ->active()
            ->approved()
            ->limit(20)
            ->get();

        return response()->json($users);
    }

    public function index()
    {
        $title = __('admin.ads');
        $page = __('admin.sidebar.ads_management');
        $pending = 0;
        $categories = Category::get();
        return view('admin.ads.index',compact(['title','page','pending', 'categories']));
    }

    public function create()
    {
        $title = __('admin.ads');
        $page = __('admin.sidebar.ads_management');
        $pending = 0;
        $mainCat = Category::roots()->get();
        $users = User::where('deleted', 0)
                    ->where('active', 1)
                    ->where('blocked', 0)
                    ->get();
        $cities = City::get();
        return view('admin.ads.create',compact(['title', 'page', 'pending', 'users', 'cities']));
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'title' => 'required',
        //     'description' => 'required',
        //     'price' => 'required',
        //     'selectedUser' => 'required',
        //     'selectedCurrency' => 'required',
        //     'category' => 'required',
        //     'staticAttributeData' => 'required',
        //     'featuredAttributeData' => 'required',
        //     'latitude' => 'required',
        //     'longitude' => 'required',
        //     'city_id' => 'required',
        //     'area_id' => 'required',
        // ]);

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:1',
            'selectedUser' => 'required',
            'selectedCurrency' => 'required',
            'category' => 'required',
            'staticAttributeData' => 'required',
            'featuredAttributeData' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'city_id' => 'required',
            'area_id' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = collect($validator->errors()->toArray())
                ->flatten()
                ->implode("\n");

            return $this->errorResponse($errors, ResponseCode::VALIDATION_ERROR);
        }
        $category = $request->input('category');
        $category = Category::find($category);
        // $attributes = $this->attributeService->getStaticAttributes($category);
        // $this->adService->checkAdAttributesInRequest($request->input('staticAttributeData'),$attributes);

        $ad=DB::transaction(function () use ($request) {
            $ad = $this->adService->createAdFromAdmin($request->all());
            return $ad;
        });

        return $this->successWithData("success",[
            'ad'=>$ad
        ]);
    }

    public function edit($id)
    {
        $title = __('admin.ads');
        $page = __('admin.sidebar.ads_management');
        $pending = 0;
        $mainCat = Category::roots()->get();
        $users = User::where('deleted', 0)
                    ->where('active', 1)
                    ->where('blocked', 0)
                    ->get();
        $cities = City::get();
        $ad = Ad::with('attributes', 'adAttributes.options')->find($id);
        if(!$ad) {
            return view('admin.ads.index',compact(['title','page','pending']));
        }
        return view('admin.ads.edit',compact(['title', 'page', 'pending', 'users', 'cities', 'ad']));
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'selectedUser' => 'required',
            'selectedCurrency' => 'required',
            'category' => 'required',
            'staticAttributeData' => 'required',
            'featuredAttributeData' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'city_id' => 'required',
            'area_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 500);
        }
        $category = $request->input('category');
        $category = Category::find($category);
        // $attributes = $this->attributeService->getStaticAttributes($category);
        // $this->adService->checkAdAttributesInRequest($request->input('staticAttributeData'),$attributes);

        $ad=DB::transaction(function () use ($id, $request) {
            $ad = $this->adService->updateAdFromAdmin($id, $request->all());
            return $ad;
        });
        if (is_string($ad)) {
            return response()->json(['error' => $ad], 500);
        }
        return $this->successWithData("success",[
            'ad'=>$ad
        ]);
    }

    public function getAdImages($id)
    {
        $ad = Ad::findOrFail($id);
        $images = $ad->media()->get()->map(function ($media) {
            return [
                'name' => $media->name,
                'size' => $media->size,
                'url' => getMediaUrl($media->name,$media->type),
                'id' => $media->id,
            ];
        });

        return response()->json($images);
    }

    public function deleteImage($id)
    {
        $media = Media::findOrFail($id);
        $media->delete();

        return response()->json(['success' => true]);
    }


    public function pending()
    {
        $title = __('admin.ads');
        $page = __('admin.sidebar.ads_management');
        $pending = 1;
        $categories = Category::get();
        return view('admin.ads.index',compact(['title','page','pending', 'categories']));
    }

    public function data(Request $request)
    {
        try {
            return $this->adService->getDatatables($request);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Failed to load ads data'], 500);
        }
    }

    public function dataPending(Request $request)
    {
        try {
            return $this->adService->getPendingDatatables($request);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Failed to load ads data'], 500);
        }
    }

    public function show($ad)
    {
        try {
            $ad = $this->adService->show($ad);

            if(!$ad)
                return back()->with('error', 'Failed to load ad details');

            $title = __('admin.ad_details');
            $page = __('admin.sidebar.ads_management');

            return view('admin.ads.show', compact('ad','title','page'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load ad details');
        }
    }

    public function changeStatus(Request $request, Ad $ad)
    {
        try {
            $request->validate([
                'status' => 'required|in:pending,approved,not_approved'
            ]);

            $this->adService->changeStatus($ad, $request->status);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to change status'], 500);
        }
    }

    public function toggleActive($ad)
    {
        try {
            $this->adService->toggleActive($ad);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to toggle active status'], 500);
        }
    }

    
    public function togglepremium($ad)
    {
        try {
            $this->adService->togglepremium($ad);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to toggle active status'], 500);
        }
    }
    public function togglesold($ad)
    {
        try {
            $this->adService->togglesold($ad);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to toggle active status'], 500);
        }
    }
    public function togglerented($ad)
    {
        try {
            $this->adService->togglerented($ad);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to toggle active status'], 500);
        }
    }
    public function togglehighlighter($ad)
    {
        try {
            $this->adService->togglehighlighter($ad);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to toggle active status'], 500);
        }
    }


    public function updateStatus($id, Request $request)
    {

        $request->validate([
            'status' => 'required|in:0,1,2'
        ]);

        try {
            DB::beginTransaction();
            $ad = Ad::findOrFail($id);

            $ad->approved = $request->status;
            $ad->status = $request->status;
            if($request->status == 1) {
                $ad->approved_by = Auth::user()->id;
            }
            if($request->status == 2){
                $paymentMethod = DraftTransaction::where('ad_id',$ad->id)->where("status","success")->orderBy('id', 'desc')->first();
                if($paymentMethod && $paymentMethod->bank_id == Bank::BANKS["PayPal"])
                {
                    if($this->payPalService->refundPayment($paymentMethod->capture_id,$paymentMethod->amount,Currency::CURRENCY[$paymentMethod->currency_id])){
                        $ad->save();
                    }
                }elseif($paymentMethod && $paymentMethod->bank_id == Bank::BANKS["Stripe"]){
                    if($this->stripeService->refundPayment($paymentMethod->capture_id)){
                        $ad->save();
                    }
                }else{
                    $ad->save();
                }
            }
            else{
                $ad->save();
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return response()->json([
                'success' => false,
                'error' => $e->getTrace(),
                'message' => 'Error updating status'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $ad = Ad::findOrFail($id);
            $ad->delete();

            return response()->json([
                'success' => true,
                'message' => 'Ad deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting ad'
            ], 500);
        }
    }

    public function nearbyAds($ad)
    {
        $ad = $this->adRepository->getAdById($ad);

        $nearbyAds = Ad::select('ad.*')
            ->selectRaw('calc_distance(lat, lng, ?, ?) * 1000 as distance', [
                $ad->lat,
                $ad->lng
            ])
            ->whereRaw('calc_distance(lat, lng, ?, ?) * 1000 <= ?', [
                $ad->lat,
                $ad->lng,
                200 // 200 meters
            ])
            ->where('active', 1)
            ->where('ad.id', '!=', $ad->id)
            ->with('media')
            ->get();

            $title = __('ads.nearby');
            $page = __('admin.sidebar.ads_management');
            return view('admin.ads.nearby', compact(['nearbyAds', 'ad','title','page']));
    }

    public function reviews()
    {
        $title = __('admin.ads_reviews.reviews');
        $page = __('admin.sidebar.ads_management');

        $reviews = AdsReview::with(['user', 'ad'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.ads.reviews', compact('reviews', 'title', 'page'));
    }

    public function reviewsData()
    {
        return DataTables::of(AdsReview::with(['user', 'ad']))
            ->addColumn('user_name', function($review) {
                return $review->user->first_name . ' ' . $review->user->last_name;
            })
            ->addColumn('user_mobile', function($review) {
                return $review->user->mobile;
            })
            ->addColumn('ad_title', function($review) {
                return $review->ad->title . ($review->ad->deleted_at ? ' (Deleted)' : '');
            })
            ->editColumn('created_at', function($review) {
                return $review->created_at->format('Y-m-d H:i');
            })
            ->rawColumns(['user_name'])
            ->make(true);
    }
}
