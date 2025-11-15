<?php

namespace App\Services;

use App\Models\Bank;
use App\Repository\TransactionsRepository;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;
use Illuminate\Support\Facades\Log;

class StripeService
{
    protected $transactionsRepository;
    public function __construct(TransactionsRepository $transactionsRepository)
    {
        $this->transactionsRepository = $transactionsRepository;
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Create a checkout session
     *
     * @param float $amount
     * @param string $currency
     * @param string $description
     * @param string $transactionId
     * @return array|null
     */
    public function createCheckoutSession($amount, $currency = 'usd', $description = 'Payment', $ad = null)
    {
        try {
            $transaction = $this->transactionsRepository->createDraftTransaction($ad->id,Bank::BANKS['Stripe'],"",$amount,$ad->user_id);
            $metadata = ['transaction_id' => $transaction->id];

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => strtolower($currency),
                        'unit_amount' => (int)($amount * 100),
                        'product_data' => [
                            'name' => $description,
                            'metadata' => $metadata,
                        ],
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'metadata' => $metadata,
                'success_url' => route('api.payment.success') . '?session_id={CHECKOUT_SESSION_ID}&transaction_id=' . $transaction->id,
                'cancel_url' => route('api.payment.cancel') . '?transaction_id=' . $transaction->id,
            ]);
            return [
                'url' => $session->url
            ];

        } catch (ApiErrorException $e) {
            Log::error('Stripe checkout creation failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Verify session payment status
     *
     * @param string $sessionId
     * @return array|null
     */
    public function verifyPayment($sessionId)
    {
        try {
            $session = Session::retrieve($sessionId);

            return [
                'status' => $session->payment_status,
                'transaction_id' => $session->metadata->transaction_id ?? null,
                'payment_intent' => $session->payment_intent,
                'amount' => $session->amount_total / 100,
                'currency' => $session->currency
            ];
        } catch (ApiErrorException $e) {
            Log::error('Stripe session verification failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Handle Stripe webhook
     *
     * @param string $payload
     * @param string $sigHeader
     * @return array|null
     */
    public function handleWebhook($payload, $sigHeader)
    {
        try {
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                config('services.stripe.webhook.secret')
            );

            $session = $event->data->object;

            switch ($event->type) {
                case 'checkout.session.completed':
                    // Get payment intent details for additional info
                    $paymentIntent = \Stripe\PaymentIntent::retrieve($session->payment_intent);

                    return [
                        'type' => 'payment_success',
                        'transaction_id' => $session->metadata->transaction_id ?? null,
                        'payment_status' => $session->payment_status,
                        'amount' => $session->amount_total / 100,
                        'currency' => $session->currency,
                        'customer_email' => $session->customer_details->email ?? null,
                        'payment_id' => $session->payment_intent,
                        'payment_method' => $paymentIntent->payment_method_types[0] ?? null,
                        'payment_created' => $paymentIntent->created,
                        'metadata' => $session->metadata->toArray()
                    ];

                case 'checkout.session.expired':
                    return [
                        'type' => 'payment_expired',
                        'transaction_id' => $session->metadata->transaction_id ?? null,
                        'metadata' => $session->metadata->toArray()
                    ];

                default:
                    return [
                        'type' => 'unhandled',
                        'event' => $event->type,
                        'metadata' => $session->metadata->toArray()
                    ];
            }
        } catch (SignatureVerificationException $e) {
            Log::error('Webhook signature verification failed: ' . $e->getMessage());
            return null;
        } catch (\Exception $e) {
            Log::error('Webhook error: ' . $e->getMessage());
            return null;
        }
    }

    public function refundPayment($paymentIntentId, $amount = null)
    {
        try {
            $refundParams = ['payment_intent' => $paymentIntentId];

            // If amount is provided, add it to refund parameters (amount in cents)
            if ($amount) {
                $refundParams['amount'] = (int)($amount * 100);
            }

            $refund = \Stripe\Refund::create($refundParams);
            $this->transactionsRepository->refundTransaction($paymentIntentId);
            return [
                'status' => 'success',
                'refund_id' => $refund->id,
                'amount' => $refund->amount / 100,
                'currency' => $refund->currency,
                'status' => $refund->status,
                'payment_intent' => $refund->payment_intent
            ];

        } catch (\Stripe\Exception\ApiErrorException $e) {
            Log::error('Stripe refund failed: ' . $e->getMessage());
            return null;
        }
    }
}
