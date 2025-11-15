<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseCode;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\UserResource;
use App\Models\User;
use App\Services\ProfileService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    function getMainInfo()
    {
        $info = $this->profileService->getMainInfo();

        return $this->successWithData("success", $info);
    }

    function myAccount()
    {
        $account = $this->profileService->myAccount();
        return $this->successWithData("success", $account);
    }

    function update(Request $request)
    {
        $request->validate([
            'first_name' => 'string|max:50',
            'last_name' => 'string|max:50',
            'call' => 'boolean',
            'notification' => 'boolean',
            'user_name' => 'string|max:50|unique:users,user_name',
            'image' => 'image|max:10240',
            'currency' => 'numeric',
            'user_type' => 'nullable'
        ]);

        $updatedProfile = $this->profileService->updateProfile($request);

        return $this->successWithData(__('profile.updated'), new UserResource($updatedProfile));
    }

    function deleteAccount(Request $request)
    {
        try {
            $user = Auth::user();
            $user->deleted = 1;
            $user->save();

            $user->ads()->update([
                "active" => 0
            ]);

            foreach ($user->tokens as $token) {
                $token->revoke(); 
            }

            return $this->successWithoutData(__('profile.accountDeleted'));
        } catch (Exception $e) {
            return $this->errorResponse("Server Error", ResponseCode::GENERAL_ERROR);
        }
    }
}
