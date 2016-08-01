<?php


namespace  App\Repositories\Transaction\TransactionRepository;
/**
 * Created by PhpStorm.
 * User: Heena M
 * Date: 7/25/2016
 * Time: 11:32 AM
 */
interface TransactionRepositoryInterface
{


    public function initiate($campaign_id,$reward_id,$input);

}