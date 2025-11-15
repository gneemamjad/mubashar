<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Transaction;
use App\Models\Ad;
use App\Models\DraftTransaction;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class StripeWebhookController extends Controller
{
    protected $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function handleWebhook(Request $request)
    {
        try {
            $payload = $request->getContent();
            $event = json_decode($payload, true);

            // Handle the checkout.session.completed event
            if ($event['type'] === 'checkout.session.completed') {
                $session = $event['data']['object'];

                // Get the transaction ID from metadata
                $transactionId = $session['metadata']['transaction_id'] ?? null;
                $paymentIntentId = $session['payment_intent'] ?? null;

                if (!$transactionId || !$paymentIntentId) {
                    Log::error('Missing transaction ID or payment intent', ['session' => $session]);
                    return response()->json(['error' => 'Missing required data'], 400);
                }

                try {
                    // Verify payment status directly from Stripe
                    $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

                    if ($paymentIntent->status !== 'succeeded') {
                        Log::error('Payment not succeeded', [
                            'transaction_id' => $transactionId,
                            'payment_intent' => $paymentIntentId,
                            'status' => $paymentIntent->status
                        ]);
                        return response()->json([
                            'error' => 'Payment not completed',
                            'status' => $paymentIntent->status
                        ], 400);
                    }



                    // Get payment details
                    $paymentDetails = [
                        'amount' => $session['amount_total'] / 100,
                        'currency' => $session['currency'],
                        'payment_status' => $paymentIntent->status,
                        'payment_intent' => $paymentIntentId,
                        'customer_email' => $session['customer_details']['email'] ?? null,
                        'payment_method' => $paymentIntent->payment_method,
                        'payment_method_types' => $paymentIntent->payment_method_types,
                    ];

                    Log::info('Payment verification successful', [
                        'transaction_id' => $transactionId,
                        'payment_intent' => $paymentIntentId,
                        'status' => $paymentIntent->status,
                        'details' => $paymentDetails
                    ]);


                    $transaction = DraftTransaction::where('id',$transactionId)->first();
                    if(!$transaction){
                        return response()->json(['error' => 'Transaction not found'], 400);
                    }

                    if($transaction->status != 'draft'){
                        return response()->json(['error' => 'Transaction not found or already paid'], 400);
                    }
                    $transaction->update(['status' => 'success','capture_id'=>$paymentIntentId]);

                    Ad::where('id',$transaction->ad_id)->update([
                        "status"   => 1,
                        "approved" => 1
                    ]);

                    return response()->json([
                        'transaction_id' => $transactionId,
                        'status' => 'success',
                        'payment_status' => $paymentIntent->status,
                        'payment_details' => $paymentDetails,
                        'message' => 'Payment verified successfully'
                    ]);

                } catch (\Exception $e) {
                    Log::error('Error verifying payment', [
                        'transaction_id' => $transactionId,
                        'payment_intent' => $paymentIntentId,
                        'error' => $e->getMessage()
                    ]);
                    return response()->json(['error' => 'Error verifying payment'], 500);
                }
            }

            return response()->json(['status' => 'success', 'type' => $event['type']]);

        } catch (\Exception $e) {
            Log::error('Webhook error', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Webhook error'], 400);
        }
    }

    public function refund(Request $request)
    {
        try {
            $request->validate([
                'payment_intent_id' => 'required|string',
                'amount' => 'nullable|numeric|min:0.01'
            ]);

            $refund = $this->stripeService->refundPayment(
                $request->payment_intent_id,
                $request->amount
            );

            if (!$refund) {
                Log::error('Refund failed', [
                    'payment_intent_id' => $request->payment_intent_id,
                    'amount' => $request->amount
                ]);
                return response()->json(['error' => 'Refund failed'], 400);
            }

            Log::info('Refund processed successfully', [
                'payment_intent_id' => $request->payment_intent_id,
                'refund' => $refund
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Refund processed successfully',
                'data' => $refund
            ]);

        } catch (\Exception $e) {
            Log::error('Refund error', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Error processing refund'], 500);
        }
    }
}
