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
use App\Models\Reel;
use App\Repository\AdRepository;
use App\Services\AdService;
use App\Services\AttributeService;
use App\Services\PayPal\PayPalService;
use App\Services\ReelService;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class ReelController extends Controller
{
    protected $reelService;
    protected $adService;
    protected $adRepository;
    protected $attributeService;
    
    public function __construct(
        ReelService $reelService,
        AdService $adService,
        AdRepository $adRepository,
        AttributeService $attributeService
    )
    {
        $this->reelService = $reelService;
        $this->adService = $adService;
        $this->adRepository = $adRepository;
        $this->attributeService = $attributeService;
    }

    public function index()
    {
        $title = __('admin.reels');
        $page = __('admin.sidebar.reels_management');
        $pending = 0;
        return view('admin.reels.index',compact(['title','page','pending']));
    }

    public function create()
    {
        $title = __('admin.reels');
        $page = __('admin.sidebar.reels_management');
        $pending = 0;
        $mainCat = Category::roots()->get();
        $users = User::where('deleted', 0)
                    ->where('active', 1)
                    ->where('blocked', 0)
                    ->get();
        $ads = Ad::where('status', Ad::STATUS['APPROVED'])->limit(50)->get();
        return view('admin.reels.create',compact(['title', 'page', 'pending', 'users', 'ads']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'selectedUser' => 'required',
            'selectedAd' => 'required',
        ]);

        $reel=DB::transaction(function () use ($request) {
            $reel = $this->reelService->createReelFromAdmin($request->all());
            return $reel;
        });

        return $this->successWithData("success",[
            'reel'=>$reel
        ]);
    }

    public function pending()
    {
        $title = __('admin.reels');
        $page = __('admin.sidebar.reels_management');
        $pending = 1;
        return view('admin.reels.index',compact(['title','page','pending']));
    }

    public function data(Request $request)
    {
        try {
            return $this->reelService->getDatatables($request);
        } catch (\Exception $e) {   
            Log::error($e->getMessage());
            return response()->json(['error' => 'Failed to load ads data'], 500);
        }
    }

    public function dataPending(Request $request)
    {
        try {
            return $this->reelService->getPendingDatatables($request);
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

    public function changeStatus(Request $request, $id)
    {
        try {
            $this->reelService->changeStatus($id);
            // return response()->json(['success' => true]);
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back();
            return response()->json(['error' => 'Failed to change status'], 500);
        }
    }
    public function delete(Request $request, $id)
    {
        try {
            $this->reelService->delete($id);
            // return response()->json(['success' => true]);
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back();
            return response()->json(['error' => 'Failed to delete'], 500);
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
