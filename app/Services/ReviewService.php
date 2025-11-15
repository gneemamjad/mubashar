<?php


namespace App\Services;

use App\Models\AdsReviewOption;
use App\Models\Voucher;
use App\Repository\AdRepository;
use App\Repository\AttributesRepository;
use App\Repository\ReviewRepository;
use App\Traits\Response;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReviewService
{

    protected $reviewRepository;

    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    function saveReview($data)
    {

        $review = $this->reviewRepository->create([
            "ad_id" => $data['ad_id'],
            "user_id" => Auth::user()->id,
            "note" => isset($data['note']) ? $data['note'] : null
        ]);    
        
        if(isset($data['options']) && count($data['options']) > 0){
            $options = [];
            foreach ($data['options'] as $option) {
                $reviewOption = new AdsReviewOption();
                $reviewOption->review_id = $review->id;
                $reviewOption->option_id = $option;
                array_push($options, $reviewOption);
            }
            $review->options()->saveMany($options);
        }

        return ;
    }

    function saveOwnerReview($data, $ownerId)
    {

        $review = $this->reviewRepository->createOwnerReview([
            "ad_id" => $data['ad_id'],
            "user_id" => Auth::user()->id,
            "owner_id" => $ownerId,
            "stars" => $data['stars'],
            "note" => isset($data['note']) ? $data['note'] : null
        ]);    

        return ;
    }

}
