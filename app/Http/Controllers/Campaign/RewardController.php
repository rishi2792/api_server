<?php
/**
 * Created by PhpStorm.
 * User: Heena M
 * Date: 7/23/2016
 * Time: 3:48 PM
 */

namespace App\Http\Controllers\Campaign;


use App\Http\Controllers\BaseController;
use App\Repositories\Campaign\RewardRepositoryInterface;
use App\Transformers\Campaign\RewardsTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class RewardController extends BaseController
{


    public function __construct(Request $request, RewardRepositoryInterface $rewardRepositoryInterface ,RewardsTransformer $rewardsTransformer)
    {
        parent::__construct($request);
        $this->rewardRepositoryInterface = $rewardRepositoryInterface;
        $this->rewardsTransformer=$rewardsTransformer;
    }


    public function index($campaign_id)
    {
        $input = Input::all();
        return $rewards = $this->rewardRepositoryInterface->get($input, $campaign_id);

    }


    public function create($campaign_id)
    {

        $input = Input::all();
         $rewards = $this->rewardRepositoryInterface->create($campaign_id, $input);
         return $this->response->item($rewards , $this->rewardsTransformer);



    }


}