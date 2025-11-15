<?php


namespace App\Services\Messages;


use App\Models\Voucher;
use App\Traits\Response;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SMSServices
{
    use Response;

    public function sendOtpMessage(string $userNumber, int $otp): void
    {
        // $this->send($userNumber, $otp, 'Elitehair_T2');
    }

    public function sendWLCMessage(string $userNumber): void
    {
        $this->send($userNumber, '', 'Elitehair_T2');
    }

    public function sendContactMessage($userNumber, $param1 , $param2): void
    {
        $this->sendMultiParams($userNumber, [
            $param1,
            $param2
        ], 'Elitehair2_T5');
    }

    public function sendTryToCallMessage(string $userNumber, string $msg): void
    {
        $this->send($userNumber, $msg, 'Elitehair_T2');
    }


    private function send(string $mobile, string $message,string $templateCode): void
    {

        $params = [
            'user_name' => 'Elitehair2',
            'password' => 'P@123456',
            'template_code' => $templateCode,
            'param_list' => $message,
            'sender' => 'Mubashar',
            'to' => $mobile
        ];

        $url = 'https://bms.syriatel.sy/API/SendTemplateSMS.aspx';

        try {
            $response = Http::get($url, $params);
            // $response = Http::withoutVerifying()
            //     ->withUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36')
            //     ->get($url, $params);

            if ($response->successful()) {
                Log::debug('SMS sent successfully. Response: ' , [
                    'response' => $response
                ]);
                Log::info('SMS sent successfully. Response: ' . $response->body());
            } else {
                Log::error('SMS sending failed. Status: ' . $response->status() . ', Body: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Exception while sending SMS: ' . $e->getMessage());
        }
    }

    private function sendMultiParams(string $mobile, array $params,string $templateCode): void
    {
        $params = [
            'user_name' => 'Elitehair2',
            'password' => 'P@123456',
            'template_code' => $templateCode,
            'param_list' => implode(";", $params),

            'sender' => 'Mubashar',
            'to' =>  $mobile
        ];

        $url = 'https://bms.syriatel.sy/API/SendTemplateSMS.aspx';

        try {
            $response = Http::get($url, $params);
            // $response = Http::withoutVerifying()
            //     ->withUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36')
            //     ->get($url, $params);

            if ($response->successful()) {
                Log::debug('SMS sent successfully. Response: ' , [
                    'response' => $response
                ]);
                Log::info('SMS sent successfully. Response: ' . $response->body());
            } else {
                Log::error('SMS sending failed. Status: ' . $response->status() . ', Body: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Exception while sending SMS: ' . $e->getMessage());
        }
    }


}
