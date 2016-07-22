<?php
/**
 * Created by PhpStorm.
 * User: Heena M
 * Date: 7/19/2016
 * Time: 6:47 PM
 */

namespace App\Repositories\Campaign;


use App\Models\campaign;
use Dingo\Api\Auth\Auth;
class CampaignRepository implements CampaignRepositoryInterface


{


    public function get($result_limit,$input){

   $q=campaign::query();
        
        if(isset($input['type'])) {
            if ($input['type'] == 'preview') {
                $q->select('id', 'name', 'description','total_budget','live_date','days');

            }
        }

            if (isset($result_limit)) {
                if (is_numeric($result_limit)) {
                    $resultLimit = $result_limit;
                } else {
                    return $q->get();
                }
            }

            return $q->Paginate($result_limit)->appends($input);
            
        }

    public function create($input){



      return  $userId=\Authorizer::getResourceOwner();
        //$campaign=campaign::create($input);

        return $campaign;


    }
            
            

        






}