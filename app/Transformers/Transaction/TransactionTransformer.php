<?php
/**
 * Created by PhpStorm.
 * User: Heena M
 * Date: 7/25/2016
 * Time: 11:54 AM
 */

namespace App\Transformers\Transaction;


use App\Models\transaction;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
{



    public function transform(transaction $transaction){

        return [


            'reward_id'=>(int)$transaction->reward_id,
            'user_id'=>(int)$transaction->user_id,
            'campaign_id'=>(int)$transaction->campaign_id,
            'status'=>(string)$transaction->status,
            'currency'=>(string)$transaction->currency,
            'is_successful'=>(boolean)$transaction->is_successful,
            'amount'=>(int)$transaction->amount,
            'campaign_awareness'=>(string)$transaction->campaign_awareness,
            'payment_gateway'=>(string)$transaction->payment_gateway,
            'payment_gateway_id'=>(int)$transaction->payment_gateway_id,
            'is_anonymous'=>(boolean)$transaction->is_anonymous,
            'is_refunded'=>(boolean)$transaction->is_refunded,



        ];
    }
}