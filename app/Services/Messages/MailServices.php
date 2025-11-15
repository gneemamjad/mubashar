<?php

namespace App\Services\Messages;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailServices
{
    public function sendOtpMessage(string $email, int $otp): void
    {
        try {
            Mail::raw("Your OTP code is: $otp", function($message) use ($email) {
                $message->to($email)
                    ->subject('Your OTP Code');
            });

            Log::info('Email sent successfully to: ' . $email);
        } catch (\Exception $e) {
            Log::error('Failed to send email: ' . $e->getMessage());
        }
    }
}
