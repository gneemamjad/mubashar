<?php


namespace App\Services;

use App\Exceptions\CustomValidationException;
use App\Http\Resources\API\AdDetailsResource;
use App\Http\Resources\API\ListAdsResource;
use App\Models\Ad;
use App\Models\Attribute as ModelsAttribute;
use App\Models\Currency;
use App\Models\Voucher;
use App\Repository\AdRepository;
use App\Repository\AttributesRepository;
use App\Repository\ReelRepository;
use App\Traits\Response;
use Attribute;
use Exception;
use Hamcrest\Type\IsNumeric;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class ReelService
{

    protected $reelRepository;

    public function __construct(ReelRepository $reelRepository)
    {
        $this->reelRepository = $reelRepository;
    }

    public function getDatatables($request)
    {
        $reels = $this->reelRepository->getWithRelations();
        return DataTables::of($reels)
            ->filter(function ($query) use ($request){
                if(isset($request->status) && $request->status != "")
                    $query->where('status',$request->status);
                if(isset($request->from_date) && $request->from_date != "")
                    $query->whereDate('created_at','>=',$request->from_date);
                if(isset($request->to_date) && $request->to_date != "")
                    $query->whereDate('created_at','<=',$request->to_date);
            },true)
            ->addColumn('owner', function ($reel) {
                return $reel->owner?->name . '<br><small>' . $reel->owner?->mobile . '</small>';
            })
            ->addColumn('ad_title', function ($reel) {
                return $reel->ad?->title;
            })
            ->addColumn('ad_number', function ($reel) {
                return $reel->ad?->ad_number;
            })
            ->addColumn('description_excerpt', function ($reel) {
                return \Str::limit($reel->description, 50);
            })
            ->addColumn('status_badge', function ($reel) {
                $badges = [
                    '0' => 'warning',
                    '1' => 'success',
                    '2' => 'danger'
                ];
                return '<span style="color:white;" class="badge bg-' . $badges[$reel->status] . '">' . ($reel->status == 1 ? 'Approved' : ( $reel->status == 0 ? "Pending" : "Rejected" )) . '</span>';
            })
            ->addColumn('created_at_formatted', function ($reel) {

                return $reel->created_at != null ? $reel->created_at->format('Y-m-d') : "";
            })
            ->addColumn('actions', function ($reel) {
                return view('admin.reels.actions', compact('reel'));
            })
            ->rawColumns(['owner', 'status_badge','actions'])
            ->make(true);
    }


    public function getPendingDatatables($request)
    {
        
        $reels = $this->reelRepository->getWithRelations();

        return DataTables::of($reels)
            ->filter(function ($query) use ($request){
                $query->where('status',Ad::STATUS['PENDING']);
                if(isset($request->status) && $request->status != "")
                    $query->where('status',$request->status);
                if(isset($request->from_date) && $request->from_date != "")
                    $query->whereDate('created_at','>=',$request->from_date);
                if(isset($request->to_date) && $request->to_date != "")
                    $query->whereDate('created_at','<=',$request->to_date);
            },true)
            ->addColumn('owner', function ($reel) {
                return $reel->owner?->name . '<br><small>' . $reel->owner?->mobile . '</small>';
            })
            ->addColumn('ad_title', function ($reel) {
                return $reel->ad?->title;
            })
            ->addColumn('ad_number', function ($reel) {
                return $reel->ad?->ad_number;
            })
            ->addColumn('description_excerpt', function ($reel) {
                return \Str::limit($reel->description, 50);
            })
            ->addColumn('status_badge', function ($reel) {
                $badges = [
                    '0' => 'warning',
                    '1' => 'success',
                    '2' => 'danger'
                ];
                return '<span style="color:white;" class="badge bg-' . $badges[$reel->status] . '">' . ($reel->status == 1 ? 'Approved' : ( $reel->status == 0 ? "Pending" : "Rejected" )) . '</span>';
            })
            ->addColumn('created_at_formatted', function ($reel) {

                return $reel->created_at != null ? $reel->created_at->format('Y-m-d') : "";
            })
            ->addColumn('actions', function ($reel) {
                return view('admin.reels.actions', compact('reel'));
            })
            ->rawColumns(['owner', 'status_badge','actions'])
            ->make(true);
    }

    function getReels($request)
    {
        return $this->reelRepository->getReels();
    }

    function getReelsPerUser($userId)
    {
        return $this->reelRepository->getReelsPerUser($userId);
    }
    
    public function toggleLike($id)
    {
        try {
            $reel = $this->reelRepository->getAdById($id);
            $result = $this->reelRepository->toggleLike($reel);
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    function createReel($data)
    {
        return $this->reelRepository->createReel($data);
    }

    function updateReel($reel, $data)
    {
        return $this->reelRepository->updateReel($reel, $data);
    }

        
    function createReelFromAdmin($data){
        $reelData = [
            'description' => $data["description"],
            'user_id' => $data["selectedUser"],
            'ad_id' => $data["selectedAd"],
            'media' => "default"
        ];

        $reel = $this->reelRepository->createReelFromAdmin($reelData);

        return $reel;

    }

    
    public function changeStatus($id)
    {
        try {
            $result = $this->reelRepository->updateStatus($id);
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    public function delete($id)
    {
        try {
            $result = $this->reelRepository->delete($id);
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    function getReelsByUser($request,$userId)
    {
        switch($request->type){
            case Ad::STATUS['APPROVED']:
                return $this->reelRepository->getApprovedAdByUserId($userId);
            case Ad::STATUS['NOT_APPROVED']:
                return $this->reelRepository->getNotApprovedAdByUserId($userId);
            case Ad::STATUS['PENDING']:
                return $this->reelRepository->getPendingAdByUserId($userId);
            default:
                return [];
        }

        return [];
    }
}
