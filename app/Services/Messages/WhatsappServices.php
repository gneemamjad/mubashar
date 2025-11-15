<?php

namespace App\Services\Messages;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

class WhatsappServices
{
    function normalizeSyrianMobile($mobile)
    {
        // Remove all non-digit characters (e.g., +, space, dash) 
        $mobile = preg_replace('/\D+/', '', $mobile); // Remove international dialing codes 
        if (strpos($mobile, '00963') === 0) {
            $mobile = substr($mobile, 5);
        } else if (strpos($mobile, '963') === 0) {
            $mobile = substr($mobile, 3);
        } // Remove leading zero if present 
        if (strpos($mobile, '0') === 0) {
            $mobile = substr($mobile, 1);
        }
        return $mobile;
    }
    public function sendOtpMessage(string $mobile, string $dial_code, int $otp, $lang = 'ar'): void
    {
        $messages = [
            'en' => [
                "Your OTP code is: :otp",
                "Use this code to verify your account: :otp",
                "Here is your OTP: :otp",
                "Enter the following OTP to continue: :otp",
                "Verification code: :otp",
                "Please use this OTP to complete your action: :otp",
                "Your secure code is: :otp"
            ],
            'ar' => [
                "رمز التحقق الخاص بك هو: :otp",
                "استخدم هذا الرمز لتأكيد حسابك: :otp",
                "إليك رمز التحقق الخاص بك: :otp",
                "أدخل رمز التحقق التالي للمتابعة: :otp",
                "رمز التحقق: :otp",
                "يرجى استخدام رمز التحقق هذا لإكمال العملية: :otp",
                "رمزك الآمن هو: :otp"
            ]
        ];
        $randomMessage = str_replace(':otp', $otp, $messages[$lang][array_rand($messages[$lang])]);
        $params = [
            'chatId' => $dial_code . $this->normalizeSyrianMobile($mobile) . '@c.us',
            'text' => $randomMessage,
            'reply_to' => 'string',
            'link_preview' => false
        ];

        $url = 'https://app.hypersender.com/api/whatsapp/v1/9ef4d709-af62-4690-8df2-eed8a7fe7616/send-text';

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Bearer 202|rmFP5fnekwupOCaxlLiIvUnQHCy7upQp4B09S1pQd4ee0d13'
            ])
            ->timeout(700)
            ->post($url, $params);

            if ($response->successful()) {
                // Log::debug('Whatsapp sent successfully. Response: ', [
                //     'response' => $response
                // ]);
                Log::info('Whatsapp sent successfully.');
            } else {
                Log::error('Whatsapp sending failed. Status: ' . $response->status() . ', Body: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Exception while sending Whatsapp: ' . $e->getMessage());
        }
    }
}
