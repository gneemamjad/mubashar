<?php


namespace App\Services;

use App\Http\Resources\API\UserResource;
use App\Models\AdsReviewOption;
use App\Models\User;
use App\Models\Voucher;
use App\Repository\AdRepository;
use App\Repository\ReelRepository;
use App\Traits\Response;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProfileService
{

    protected $adRepository;
    protected $reelRepository;

    public function __construct(AdRepository $adRepository, ReelRepository $reelRepository)
    {
        $this->adRepository = $adRepository;
        $this->reelRepository = $reelRepository;
    }

    function getMainInfo()
    {
        $user = Auth::user();

        $adsInfo = $this->adRepository->getUserAdsDetailsMetrics($user->id);
        $reelsInfo = $this->reelRepository->getUserReelsDetailsMetrics($user->id);
        
        return ["ad_info" => $adsInfo , "reel_info" => $reelsInfo , "user" => new UserResource($user)];
      
    }

    function updateProfile($request)
    {
        $user = Auth::user();

     
        
        if($request->has('first_name'))
            $user->first_name = $request->first_name;

        if($request->has('last_name'))
            $user->last_name = $request->last_name;

        if($request->has('user_name'))
            $user->user_name = $request->user_name;

        if($request->has('call'))
            $user->call = $request->call;

        if($request->has('notification'))
            $user->notification = $request->notification;

        if($request->has('user_type'))
            $user->user_type = $request->user_type;

        if($request->has('image')){
            $imageName = uploadMedia($request->image, MEDIA_TYPES["image"]);
            $user->image = $imageName;
        }

        if($request->has('currency')){
            $user->currency_id = $request->currency;            
            Cache::forget('user_currency_symbol_'.$user->id);
            Cache::forget('user_currency_'.$user->id);
            Cache::forget('user_currency_rate_'.$user->id);
        }

        if($user->user_name == null || $user->user_name == ''){

       

            $firstName = strtolower($user->first_name);
            $lastName = strtolower($user->last_name);
            
            $usernameVariations = [
                $firstName . '.' . $lastName,
                substr($firstName, 0, 1) . $lastName,
                $firstName . substr($lastName, 0, 1),
                substr($firstName, 0, 1) . '.' . $lastName,
            ];
    
            $existingUsernames = User::whereIn('user_name', $usernameVariations)
                ->pluck('user_name')
                ->map('strtolower')
                ->flip()
                ->toArray();
    
            $username = null;
    
            foreach ($usernameVariations as $variation) {
                if (!isset($existingUsernames[strtolower($variation)])) {
                    $username = $variation;
                    break;
                }
            }
    
            if (!$username) {
                $counter = 1;
                do {
                    $newUsername = $firstName . $lastName . $counter;
                    if (!isset($existingUsernames[strtolower($newUsername)])) {
                        $username = $newUsername;
                        break;
                    }
                    $counter++;
                } while (true);
            }
            $user->user_name = $username;
        }

        $user->save();    

        return $user;
    }

    function myAccount()
    {
        $user = Auth::user();
        
        $firstName = strtolower($user->first_name);
        $lastName = strtolower($user->last_name);
        
        $usernameVariations = [
            $firstName . '.' . $lastName,
            substr($firstName, 0, 1) . $lastName,
            $firstName . substr($lastName, 0, 1),
            substr($firstName, 0, 1) . '.' . $lastName,
        ];

        $existingUsernames = User::whereIn('user_name', $usernameVariations)
            ->pluck('user_name')
            ->map('strtolower')
            ->flip()
            ->toArray();

        $username1 = null;
        $username2 = null;

        foreach ($usernameVariations as $username) {
            if (!isset($existingUsernames[strtolower($username)])) {
                if (!$username1) {
                    $username1 = $username;
                } elseif (!$username2) {
                    $username2 = $username;
                    break;
                }
            }
        }

        $counter = 1;
        while (!$username1 || !$username2) {
            $newUsername = $firstName . $lastName . $counter;
            if (!isset($existingUsernames[strtolower($newUsername)])) {
                if (!$username1) {
                    $username1 = $newUsername;
                } elseif (!$username2) {
                    $username2 = $newUsername;
                    break;
                }
            }
            $counter++;
        }

        return ["account" => new UserResource($user) , "user_names" => [$username1,$username2]];
    }
}
