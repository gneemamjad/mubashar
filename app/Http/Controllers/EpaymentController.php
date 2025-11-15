<?php

namespace App\Http\Controllers;

use App\Models\DraftTransaction;
use App\Repository\TransactionsRepository;
use App\Services\PayPal\PayPalService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class EpaymentController extends Controller
{
    private $paypalService;
    private $transactionsRepository;

    public function __construct(TransactionsRepository $transactionsRepository, PayPalService $paypalService)
    {
        $this->paypalService = $paypalService;
        $this->transactionsRepository = $transactionsRepository;
    }

    function successPayment(Request $request)
    {
        return view('paymentSuccess');
    }

    function webhookSuccess(Request $request)
    {
          $eventType = $request->input('event_type');
         
          Log::debug("eventType",[
            "eventType" => $eventType
        ]);

          // Process the event
          switch ($eventType) {
              case 'CHECKOUT.ORDER.APPROVED':
                  $resource = $request->input('resource');
                  $invoiceId = $resource['id'] ?? null;
                  $this->paypalService->captureOrder($invoiceId);
                  break;
              case 'PAYMENT.CAPTURE.COMPLETED':
                  $resource = $request->input('resource');
                  $invoiceId = $resource['supplementary_data']['related_ids']['order_id'] ?? null;
                  $captureId = $resource['id'] ?? null;
                  Log::debug("CAPTURE",[
                    "captureId" => $captureId
                  ]);

                 

                  $this->transactionsRepository->paidDraftTransaction($invoiceId,$captureId);
                  break;
              case 'PAYMENT.CAPTURE.REFUNDED':
                  $resource =  $request->input('resource');
                  $links = $resource['links'] ?? [];
                  // Extract the original capture_id
                  $captureId = null;
                  foreach ($links as $link) {
                    Log::debug("CAPTURE",[
                        "link" => $link
                      ]);
                      if ($link['rel'] == 'up') {
                          $captureId = basename($link['href']); // Extract capture_id from URL
                          break;
                      }
                  }                  
                  Log::debug("CAPTURE",[
                    "captureId" => $captureId
                  ]);
                  $this->transactionsRepository->refundTransaction($captureId);
                  break;
  
              default:
                  break;
          }
  
          return response()->json(['message' => 'Webhook processed'], 200);
    }
    
} 