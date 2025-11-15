<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\CurrencyResource;
use App\Models\Bank;
use App\Models\Currency;
use App\Models\DraftTransaction;
use App\Services\StripeService;
use Illuminate\Http\Request;
use App\Traits\Response;
use Illuminate\Support\Facades\Cache;

class PaymentController extends Controller
{
    use Response;

    protected $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    public function createCheckout(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.5',
            'currency' => 'required|string|size:3',
            'description' => 'nullable|string',
            'transaction_id' => 'required|string'
        ]);

        $checkoutSession = $this->stripeService->createCheckoutSession(
            $request->amount,
            $request->currency,
            $request->description ?? 'Payment',
            $request->transaction_id
        );

        if (!$checkoutSession) {
            return $this->errorResponse('Failed to create checkout session');
        }

        return $this->successWithData('Checkout session created', [
            'checkout_url' => $checkoutSession['url']
        ]);
    }

    public function success(Request $request)
    {
        $request->validate([
            'session_id' => 'required|string',
            'transaction_id' => 'required|string'
        ]);

        $paymentInfo = $this->stripeService->verifyPayment($request->session_id);

        if (!$paymentInfo) {
            return $this->errorResponse('Failed to verify payment');
        }

        if ($paymentInfo['transaction_id'] !== $request->transaction_id) {
            return $this->errorResponse('Invalid transaction ID');
        }

        // Here you can update your transaction status in the database
        // Example: Transaction::where('id', $request->transaction_id)->update(['status' => 'paid']);
        $transaction = DraftTransaction::where('id',$paymentInfo['transaction_id'])->first();
        if($transaction && $transaction->status == 'draft'){
            $transaction->update(['status' => 'success','capture_id'=>$paymentInfo['payment_intent']]);
        }elseif($transaction && $transaction->status == 'success'){
            return $this->errorResponse('Success Paid ');
        }else{
            return $this->errorResponse('Transaction not found');
        }
        return $this->successWithData('Payment successful', $paymentInfo);
    }

    public function cancel(Request $request)
    {
        $transactionId = $request->get('transaction_id');

        // Here you can update your transaction status to cancelled
        // Example: Transaction::where('id', $transactionId)->update(['status' => 'cancelled']);

        return $this->errorResponse('Payment cancelled');
    }

    function getCurrenciesByBank($bankId)
    {
        $currencies = [];        

        if($bankId == Bank::BANKS['PayPal'])
            $currencies = Cache::remember('PayPal-Currencies', 60*24, function() {
                return Currency::where('id',2)->get();
            });

        if($bankId == Bank::BANKS['Stripe'])
            $currencies = Cache::remember('Stripe-Currencies', 60*24, function() {
                return Currency::whereIn('id',[2,3])->get();
            });

        
        return $this->successWithData("success",CurrencyResource::collection($currencies));

    }
}
