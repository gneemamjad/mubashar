<?php

namespace App\Services\PayPal;

use App\Models\DraftTransaction;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Payments\CapturesRefundRequest;
use App\Models\Bank;
use App\Repository\TransactionsRepository;
use Exception;
use Illuminate\Support\Facades\Log;
use PayPal\Api\RefundRequest;
use PayPalCheckoutSdk\Payments\RefundsGetRequest;

class PayPalService
{
    private $client;
    private $transactionsRepository;

    public function __construct(TransactionsRepository $transactionsRepository)
    {
        $this->client = $this->getPayPalClient();
        $this->transactionsRepository = $transactionsRepository;
    }

    private function getPayPalClient(): PayPalHttpClient
    {
        $environment = app()->environment('production')
            ? new ProductionEnvironment(config('paypal.client_id'), config('paypal.client_secret'))
            : new SandboxEnvironment(config('paypal.client_id'), config('paypal.client_secret'));

            return new PayPalHttpClient(new SandboxEnvironment("AfLcfpk_Lerp4OaTzRzBDg9EB1eawBPdcxGkoVdYiBDxt-ecllF2_K2yKdNSxDkK1neZALfy7Ot9UnPo","EL7ie-pxs1zo0nc3EAxizPH1j2Q9bHyYwzNM6hNFaZ18XCQn-J0EXBShIGOKdFvhP901JTvaAKufxrR8"));    }

    public function createOrder(float $amount, string $currency = 'USD', $ad): array
    {
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');

        $request->body = [
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => $currency,
                    'value' => number_format($amount, 2, '.', '')
                ]
            ]],
            'application_context' => [
                'return_url' => route('payment.success'),
                // 'cancel_url' => route('paypal.cancel'),

            ]
        ];

        try {
            $response = $this->client->execute($request);

            $this->transactionsRepository->createDraftTransaction($ad->id,Bank::BANKS['PayPal'],$response->result->id,$amount,$ad->user_id);

            return [
                'status' => true,
                'order_id' => $response->result->id,
                'approval_url' => collect($response->result->links)
                    ->where('rel', 'approve')
                    ->first()
                    ->href
            ];
        } catch (Exception $e) {
            Log::error($e);
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function captureOrder(string $orderId): array
    {

        Log::debug("paypal",[
            "creation" => "success"
        ]);

        $request = new OrdersCaptureRequest($orderId);

        try {
            $response = $this->client->execute($request);


            Log::error('PayPal OrdersCaptureRequest', [
                'response' => $response

            ]);

            Log::error('PayPal OrdersCaptureRequest', [
                'status' => true,
                'order_id' => $response->result->id,
                'payment_status' => $response->result->status
            ]);

            return [
                'status' => true,
                'order_id' => $response->result->id,
                'payment_status' => $response->result->status
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function refundPayment(string $captureId, float $amount, string $currency = 'USD')
    {
        Log::debug("start refund",[
            "captureId" => $captureId
        ]);

        try {
            // Verify if capture exists first
            $request = new CapturesRefundRequest($captureId);
            $request->body = [
                'amount' => [
                    'value' => $amount,
                    'currency_code' => $currency
                ]
            ];

            $response = $this->client->execute($request);

            Log::debug("Refund successful", [
                'capture_id' => $captureId,
                'refund_id' => $response->result->id,
                'status' => $response->result->status
            ]);

            return true;

        } catch (Exception $e) {
            $errorData = json_decode($e->getMessage(), true);

            Log::error('PayPal refund failed', [
                'capture_id' => $captureId,
                'error_name' => $errorData['name'] ?? 'Unknown Error',
                'error_message' => $errorData['message'] ?? $e->getMessage(),
                'debug_id' => $errorData['debug_id'] ?? null,
                'details' => $errorData['details'] ?? []
            ]);

            return false;
        }
    }

}
