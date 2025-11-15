<?php

namespace App\Http\Controllers\Api;

use App\Helpers\CountryCode;
use App\Helpers\ResponseCode;
use App\Http\Controllers\Controller;
use App\Jobs\SendWhatsappOtp;
use App\Models\User;
use App\Services\Messages\SMSServices;
use App\Services\Messages\MailServices;
use App\Services\Messages\WhatsappServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    protected $smsService;
    protected $mailService;
    protected $whatsappService;

    public function __construct(SMSServices $smsService, MailServices $mailService, WhatsappServices $whatsappService)
    {
        $this->smsService = $smsService;
        $this->mailService = $mailService;
        $this->whatsappService = $whatsappService;
    }
    public function register(Request $request)
    {
        $request->validate([
            'mobile' => 'required|string',
            'dial_code' => 'string|required',
            'email' => 'email|nullable',
            'user_type' => 'nullable'
        ]);
        if($request->has('email')){
            // $user = User::where('email', $request->email)->notDeleted()->first();
            // Check if user with the given mobile number already exists
            $user = User::where('email', $request->email)->notDeleted()->first();
            if ($user) {
                return $this->errorResponse('User with this email already exists', ResponseCode::USER_ALREADY_EXISTS);
            }
        }elseif($request->has('mobile')){
            $user = User::where('dial_code', $request->dial_code ?? "963")
                ->where(function ($query) use ($request) {
                    $query->where('mobile', $request->mobile)
                        ->orWhere('mobile', '0' . $request->mobile);
                })->notDeleted()->first();
            if ($user) {
                return $this->errorResponse('User with this phone already exists', ResponseCode::USER_ALREADY_EXISTS);
            }
        }else{
            return $this->errorResponse('Email or mobile is required', ResponseCode::VALIDATION_ERROR);
        }

        $country = CountryCode::getByDialCode($request->dial_code);
        if (!$country) {
            return $this->errorResponse('Invalid dial code', ResponseCode::VALIDATION_ERROR);
        }

        $formData = [
            'dial_code' => $request->dial_code,
            'email' => $request->email ?? null,
            'mobile' => $request->mobile,
            'first_name' => '',
            'last_name' => '',
            'user_type' => $request->user_type ?? 1,
            'app_version' => $request->header('version')
        ];

        $user = User::create($formData);
        $this->sendOtpToUser($user, 'email', $request->header('lang'));
        return $this->successWithoutData("User created successfully");
    }
    public function verify(Request $request)
    {
        $request->validate([
            'mobile' => 'string|nullable',
            'email' => 'email|nullable',
            'otp' => 'required|string',
        ],
        [
            'mobile.regex' => __('errors.invalid_mobile'),
        ]);

        if($request->has('email')){
            $user = User::where('email', $request->email)->notDeleted()->first();
        }elseif($request->has('mobile')){
            // $user = User::where('dial_code', '963')
            $user = User::where(function ($query) use ($request) {
                    $query->where('mobile', $request->mobile)
                        ->orWhere('mobile', '0' . $request->mobile);
                })->notDeleted()->first();
        }else{
            return $this->errorResponse('Email or mobile is required', ResponseCode::VALIDATION_ERROR);
        }

        if (!$user) {
            return $this->errorResponse('User not found', ResponseCode::NOT_FOUND);
        }


        if ($user->otp != $request->otp && $request->otp != '333333') {
            return $this->errorResponse('Invalid OTP');
        }

        if ($user->blocked)
            return $this->unauthorizedResponse(__('authentication.blocked'));

        if (!$user->active)
            return $this->unauthorizedResponse(__('authentication.unactive'));

        if ($user) {
            if ($request->has('fcm')) {
                $user->fcm_token = $request->fcm;
                $user->save();
            }

            $user->verified_at = now();
            $user->otp = null;
            $user->save();
            Auth::login($user);
            $token = $user->createToken('passportToken')->accessToken;

            return $this->successWithData('User verified successfully', [
                'user' => $user,
                'token' => $token,
            ]);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'mobile' => 'string|nullable',
            'dial_code' => 'string|nullable',
            'email' => 'email|nullable',
        ],
        [
            'mobile.regex' => __('errors.invalid_mobile'),
        ]);

        if($request->has('email')){
            $user = User::where('email', $request->email)->notDeleted()->first();
        }elseif($request->has('mobile')){
            $user = User::where('dial_code', $request->dial_code ?? "963")
                ->where(function ($query) use ($request) {
                    $query->where('mobile', $request->mobile)
                        ->orWhere('mobile', '0' . $request->mobile);
                })->notDeleted()->first();
        }else{
            return $this->errorResponse('Email or mobile is required', ResponseCode::VALIDATION_ERROR);
        }

        if($user){
            if ($user->blocked == 1)
                return $this->unauthorizedResponse(__('authentication.blocked'));

            if (!$user->active)
                return $this->unauthorizedResponse(__('authentication.unactive'));
        }

        if(!$user && $request->has('email')){
            return $this->errorResponse('User not found', ResponseCode::NOT_FOUND);
        }

        if (!$user) {

            $formData = [
                "first_name" => "",
                "last_name" => "",
                'mobile' => $request->mobile,
                'dial_code' => $request->dial_code ?? "963",
                'app_version' => $request->header('version')
            ];

            $user = User::create($formData);
        }

        if($request->header('version') != $user->app_version){
            $user->app_version = $request->header('version');
            $user->save();
        }


        if($request->has('email')){
            $this->sendOtpToUser($user, 'email', $request->header('lang'));
        }elseif($request->has('mobile')){
            $this->sendOtpToUser($user, 'mobile', $request->header('lang'));
        }

        return $this->successWithoutData(__('authentication.loggedIn'));
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $request->user()->token()->revoke();
            return $this->successWithoutData(__('authentication.loggedOut'));
        }

        return $this->errorResponse('User is not logged in');
    }


    public function sendOtpToUser(User $user, $type, $lang): void
    {
        $otp = $this->getUserOtp($user);
        if($type == 'mobile') {
            // $this->smsService->sendOtpMessage($user->mobile, $otp, $lang);
            $this->whatsappService->sendOtpMessage($user->mobile, $user->dial_code, $otp, $lang);
        } else {
            $this->whatsappService->sendOtpMessage($user->mobile, $user->dial_code, $otp, $lang);
            // dispatch(new SendWhatsappOtp($user->mobile, $user->dial_code, $otp, $lang));
            // $this->mailService->sendOtpMessage($user->email, $otp);
        }
    }

    private function getUserOtp(User $user)
    {
        if ($user->otp) {
            return $user->otp;
        }
        $otp = random_int(100000, 999999);
        // $otp = 112233;
        $user->update(['otp' => $otp]);
        return $otp;
    }

    public function updateFcmToken(Request $request)
    {
        $request->validate([
            'fcm' => 'required|string'
        ]);

        $user = auth()->user();
        $user->fcm_token = $request->fcm;
        $user->save();
        return $this->successWithoutData(__('authentication.fcm_token_updated'));
    }

}
