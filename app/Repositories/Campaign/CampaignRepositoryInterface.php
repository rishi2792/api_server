<?php
/**
 * Created by PhpStorm.
 * User: Heena M
 * Date: 7/19/2016
 * Time: 6:47 PM
 */

namespace App\Repositories\Campaign;

interface CampaignRepositoryInterface {
    
    
    
    public function get($result_limit,$input);
    public function create($input);
//    public function post();
    public function addteam($campaign_id,$input);
//    public function delete();
//
    public function budget($campaign_id,$input);
}