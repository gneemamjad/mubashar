<?php

namespace App\Repository;

use App\Exceptions\CategoryNotFoundException;
use App\Models\Ad;
use App\Models\AdsReview;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\DraftTransaction;
use App\Models\PriceHistory;
use App\Models\ReviewOption;
use Illuminate\Support\Facades\Cache;

class TransactionsRepository{

    function createDraftTransaction($adId,$bankId,$transactionId,$amount,$user_id)
    {
        return DraftTransaction::create([
            "ad_id" => $adId,
            "bank_id" => $bankId,
            "user_id" => $user_id,
            "transaction_id" => $transactionId,
            "status" => "draft",
            "amount" => number_format($amount, 2, '.', '')
        ]);

    }

    function paidDraftTransaction($transactionId,$captureId = null)
    {
        $transaction =  DraftTransaction::where('transaction_id', $transactionId)->first();
        $transaction->status = 'success';
        $transaction->capture_id = $captureId;
        $transaction->save();

        Ad::where('id',$transaction->ad_id)->update([
            "status"   => 1,
            "approved" => 1
        ]);
        // DraftTransaction::where('transaction_id', $transactionId)
        // ->update(['status' => 'success','capture_id'=>$captureId]);
        return true;
    }

    function refundTransaction($captureId)
    {
        DraftTransaction::where('capture_id', $captureId)
        ->update(['status' => 'refunded']);
        return true;
    }

}
