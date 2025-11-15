<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseCode;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\ListReelsResource;
use App\Repository\ReelRepository;
use App\Services\ReelService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ReelController extends Controller
{
    protected $reelRepository;
    protected $reelService;

    public function __construct(
            ReelService $reelService,
            ReelRepository $reelRepository
    )
    {
        $this->reelService = $reelService;
        $this->reelRepository = $reelRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        try{
            $reels = $this->reelService->getReels($request);
            return $this->successWithDataPagination("success",ListReelsResource::collection($reels),$reels);
        }
        catch(Exception $e){
            Log::error('Error in get ads', ['error' => $e->getMessage()]);
            return $this->errorResponse("Server Error",ResponseCode::GENERAL_ERROR);
        }

    }
    /**
     * Display a listing of the resource.
     */
    public function indexByUser($user_id) {
        try{
            $reels = $this->reelService->getReelsPerUser($user_id);
            return $this->successWithDataPagination("success",ListReelsResource::collection($reels),$reels);
        }
        catch(Exception $e){
            Log::error('Error in get ads', ['error' => $e->getMessage()]);
            return $this->errorResponse("Server Error",ResponseCode::GENERAL_ERROR);
        }

    }
    /**
     * Update Like and Dislike
     */
    public function updateLike($id) {
        try {
            $this->reelService->toggleLike($id);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            dd($e);
            return response()->json(['error' => 'Failed to toggle like status'], 500);
        }
    }

    /**
     * Create a new resource.
     */
    public function create(Request $request)
    {
        $request->validate([
            'ad_id' => 'required|exists:ad,id',
            'media' => 'required|file',
            'description' => 'required|string'
        ]);

        try{
            $mediaPath = $request->file('media')->store('reels/media', 'public');
            $mediaUrl = Storage::disk('public')->url($mediaPath);

            $reel = $this->reelService->createReel([
                'ad_id' => $request->ad_id,
                'media' => $mediaUrl,
                'description' => $request->description
            ]);


            return $this->successWithData("success",[
                'reel'=>$reel
            ]);
        }
        catch(Exception $e){
            Log::error('Error in store ad', ['error' => $e->getMessage()]);
            return $this->errorResponse("Server Error",ResponseCode::GENERAL_ERROR);
        }
    }

        
    public function addReelFromAdmin(Request $request)
    {
        $request->validate([
            'reel_id' => 'required|numeric',
            'file'    => 'required|array',
            'file.0'  => 'required|file|mimes:mp4,mov,avi,webm|max:51200', // max 50MB
        ]);

        $reel = $this->reelRepository->getAdById($request->reel_id);
        if (!$reel) {
            return $this->notFoundResponse(__('reels.notFound'));
        }

        $uploadedFile = $request->file('file')[0];
        $mediaPath = $uploadedFile->store('reels/media', 'public');
        $mediaUrl = Storage::disk('public')->url($mediaPath);

        $this->reelService->updateReel($reel, [
            'reel' => $mediaUrl
        ]);

        return $this->successWithoutData("success");
    }

    

    function getMyReels(Request $request)
    {

        $request->validate([
            'type' => 'required|numeric|in:0,1,2'
        ]);

        $user = Auth::user();
        $reels = $this->reelService->getReelsByUser($request,$user->id);
        return $this->successWithDataPagination("success",ListReelsResource::collection($reels),$reels);
    }

}
