<?php
/**
 * Created by PhpStorm.
 * User: Heena M
 * Date: 7/23/2016
 * Time: 3:44 PM
 */

namespace App\Repositories\Campaign;


interface RewardRepositoryInterface
{

    
    public function create($campaign_id,$input);
}