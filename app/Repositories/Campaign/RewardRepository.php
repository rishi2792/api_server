<?php
/**
 * Created by PhpStorm.
 * User: Heena M
 * Date: 7/23/2016
 * Time: 3:44 PM
 */

namespace App\Repositories\Campaign;


use App\Models\rewards;

class RewardRepository implements RewardRepositoryInterface
{
  public function create($campaign_id,$input)
  {


      foreach($input['reward'] as $key=>$value){


            $rewards=rewards::create([
                'name'=>$value['name'],
                'descprition'=>$value['descprition'],
                'amount'=>$value['amount'],
                'shipping_estimate_date'=>$value['shipping_estimate_date'],
                'limit'=>$value['limit'],
                'campaign_id'=>$campaign_id

            ]);

      }

     return $rewards;


  }
    
    


}