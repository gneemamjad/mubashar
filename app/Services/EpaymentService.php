<?php


namespace App\Services;

use App\Models\Bank;
use App\Models\Currency;
use App\Services\PayPal\PayPalService;

class EpaymentService
{

    protected $payPalService;
    protected $stripeService;

    public function __construct(PayPalService $payPalService,StripeService $stripeService)
    {
        $this->payPalService = $payPalService;
        $this->stripeService = $stripeService;
    }


    function initPaymentUrl($bankId,$ad,$plan,$currency)
    {
        $currencySymbol = Bank::CURRENCY[$currency->id];

        if($bankId == Bank::BANKS['PayPal']){
            return $this->payPalService->createOrder(getExchangedPrice($plan->price,1,$currency->id),$currencySymbol,$ad)['approval_url'];
        }elseif($bankId == Bank::BANKS['Stripe']){
            return $this->stripeService->createCheckoutSession(getExchangedPrice($plan->price,1,$currency->id),$currencySymbol,'Pay Ad Plan',$ad)['url'];
        }
    }




}
