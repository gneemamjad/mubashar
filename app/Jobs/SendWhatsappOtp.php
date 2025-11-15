<?php

namespace App\Jobs;

use App\Services\Messages\WhatsappServices;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWhatsappOtp implements ShouldQueue
{
   use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mobile;
    protected $dial_code;
    protected $otp;
    protected $lang;

    public function __construct(string $mobile, string $dial_code, int $otp ,string $lang)
    {
        $this->mobile = $mobile;
        $this->dial_code = $dial_code;
        $this->otp = $otp;
        $this->lang = $lang;
    }

    public function handle(WhatsappServices $whatsappService)
    {
        $whatsappService->sendOtpMessage($this->mobile, $this->dial_code, $this->otp, $this->lang);
    }
}
