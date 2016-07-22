<?php
/**
 * Created by PhpStorm.
 * User: Heena M
 * Date: 7/20/2016
 * Time: 5:16 PM
 */

namespace App\Transformers\Campaign;


use App\Models\rewards;
use League\Fractal\TransformerAbstract;

class RewardsTransformer extends TransformerAbstract

{


    protected $availableIncludes = [


    ];

    public function transform(rewards $rewards)
    {
        // Specify what elements are going to be visible to the API
        return [
            'id' => (int)$rewards->id,
            'name' => (string)$rewards->name,
            'description' => (string)$rewards->description,
            'amount' => (string)$rewards->amount,
            'is_pledged' => (boolean)$rewards->is_pledged,
            'reward_count' => (boolean)$rewards->reward_count,
            'limit' => (string)$rewards->limit,
            'shipping_estimate_date' => (string)$rewards->shipping_estimate_date,
            'campaign_id' => (string)$rewards->campaign_id,
            'created_at' => (string)$rewards->created_at,
            'updated_at' => (string)$rewards->updated_at,
        ];
    }
}