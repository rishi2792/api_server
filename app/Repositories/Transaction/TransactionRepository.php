<?php
namespace  App\Repositories\Transaction\TransactionRepository;
use App\Models\transaction;

/**
 * Created by PhpStorm.
 * User: Heena M
 * Date: 7/25/2016
 * Time: 11:33 AM
 */
class TransactionRepository implements TransactionRepositoryInterface
{


    public function initiate($campaign_id,$reward_id,$input){


        $transaction=transaction::create([

            'reward_id'=>$reward_id,
            'user_id'=> \Authorizer::getResourceOwnerId(),
            'campaign_id'=>$campaign_id,
            'status'=>'initiated',
            'amount'=>$input['amount'],
            'currency'=>$input['currency']

        ]);

        return $transaction;
    }


}


