<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseCode;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\ReviewOptionResource;
use App\Repository\AdRepository;
use App\Repository\ReviewRepository;
use App\Services\ReviewService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{

    protected $reviewRepository;
    protected $adRepository;
    protected $reviewService;

    public function __construct(ReviewRepository $reviewRepository, AdRepository $adRepository, ReviewService $reviewService)
    {
        $this->reviewRepository = $reviewRepository;
        $this->adRepository = $adRepository;
        $this->reviewService = $reviewService;

    }

    function getOptions()
    {
        try{
            $options = ReviewOptionResource::collection($this->reviewRepository->getReviewOptions());
            return $this->successWithData("success",$options);
        }
        catch(Exception $e){
            return $this->errorResponse("Server Error",ResponseCode::GENERAL_ERROR);
        }
    }

    function store(Request $request)
    {

        $request->validate([
            'ad_id' => 'required',
            'options' => 'array|required',
            'note' => 'nullable|max:200'
        ]);

        try{

            $ad = $this->adRepository->getAdById($request->ad_id);

            if(!$ad)
                return $this->notFoundResponse(__('ads.notFound'));



            if(Auth::user()->reviewing->contains($request->ad_id))
                return $this->notFoundResponse(__('reviews.reviewdBefore'));

            $this->reviewService->saveReview($request->all());

            return $this->successWithoutData(__('reviews.addedReview'));
        }
        catch(Exception $e){
            return $this->errorResponse("Server Error",ResponseCode::GENERAL_ERROR);
        }
    }

    

    function storeOwnerReview(Request $request)
    {

        $request->validate([
            'ad_id' => 'required',
            'stars' => 'required',
            'note' => 'nullable|max:200'
        ]);

        try{

            $ad = $this->adRepository->getAdById($request->ad_id);

            if(!$ad)
                return $this->notFoundResponse(__('ads.notFound'));

            if(Auth::user()->ownerReviewing->contains($request->ad_id))
                return $this->notFoundResponse(__('reviews.reviewdBefore'));

            $this->reviewService->saveOwnerReview($request->all(), $ad->user_id);

            return $this->successWithoutData(__('reviews.addedReview'));
        }
        catch(Exception $e){
            return $this->errorResponse("Server Error",ResponseCode::GENERAL_ERROR);
        }
    }
}
