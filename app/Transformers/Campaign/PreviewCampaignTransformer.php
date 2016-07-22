<?php
/**
 * Created by PhpStorm.
 * User: Heena M
 * Date: 7/20/2016
 * Time: 12:50 PM
 */

namespace App\Transformers\Campaign;

use App\Models\campaign;
use App\Transformers\Image\ImageTransformer;
use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;
use DB;
use App\Transformers\Users\UserTransformer;
use Request;

class PreviewCampaignTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'stransactions',
        'users'
        // 'percentpledged'

    ];

    public function transform(campaign $campaign)
    {
        // Specify what elements are going to be visible to the API
        return [
            'id' => (int)$campaign->id,
            'name' => (string)$campaign->name,
            'description' => (string)$campaign->description,
//            'about' => (string)$campaign->about,
//            'faq' => (boolean)$campaign->faq,
            'days' => (integer)$campaign->days,
//            'budget' => (string)$campaign->budget,
//            'social_handle' => (string)$campaign->social_handle,
//            'status' => (string)$campaign->status,
//            'contributer_message' => (string)$campaign->contributer_message,
//            'is_locked' => (string)$campaign->is_locked,
//            'is_active' => (string)$campaign->is_active,
            'live_date' => (string)$campaign->live_date,
//            'location' => (string)$campaign->location,
            'total_budget' => (string)$campaign->total_budget,
//            'created_at' => (string)$campaign->created_at,
//            'updated_at' => (string)$campaign->updated_at,
        ];
    }

    public function includeStransactions(campaign $campaign)
    {

        //  if ($campaign && $campaign->stransactions) {

        $amount = DB::table('campaign_success_transaction')->where('id', $campaign->id)->sum('amount');
        $backers = DB::table('transactions')->where('campaign_id', $campaign->id)->where('is_successful', 1)->count('user_id');
        //  $target=DB::table('campaign')->where('id',$campaign->id)->pluck('total_budget');
        $percent = $amount / $campaign->total_budget * 100;

        $today = new \DateTime(date('Y-m-d'));


        $live_date = new \DateTime($campaign->live_date);
        $interval = $today->diff($live_date)->format('%R%a');

        $i = abs($interval);
        $daysleft = $campaign->days - $i;


        $total = ['raised' => $amount, 'daysleft' => $daysleft, 'plegePercent' => $percent];
        return $this->item([$total], function ($total) {
            return $total;
        }
        );


    }

    public function includeUsers(campaign $campaign)
    {

        $users = null;
        $name = null;
        $img = null;

        if ($campaign && $campaign->creator) {


            $users = $campaign->creator;
            foreach ($users as $user) {
                $name = $user->name;
                if($user->image) {
                    $image = $user->image;
                    $server = "" . Request::getUri();
                    $server = substr($server, 0, (strpos($server, "api/v1") - 1));
                    $img = "" . $server . "/api/v1/image/" . "/" . $image->id;
                }
            }
        }
        $output = ['name' => $name, 'image_url' => $img];

        return $this->item([$output], function ($output) {
            return $output;
        });


    }
}