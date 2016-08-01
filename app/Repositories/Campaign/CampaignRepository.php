<?php
/**
 * Created by PhpStorm.
 * User: Heena M
 * Date: 7/19/2016
 * Time: 6:47 PM
 */

namespace App\Repositories\Campaign;


use App\Models\campaign;
use App\Models\User;
use Dingo\Api\Auth\Auth;
use DB;
use Intervention\Image\Facades\Image;
use Request;
use Illuminate\Support\Facades\Input;
class CampaignRepository implements CampaignRepositoryInterface


{


    public function get($result_limit, $input)
    {

        $q = campaign::query();

        if (isset($input['type'])) {
            if ($input['type'] == 'preview') {
                $q->select('id', 'name', 'description', 'total_budget', 'live_date', 'days');

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

    public function create($input)
    {

        $allsocial = [];

        $userId = \Authorizer::getResourceOwnerId();
        $user = User::find($userId);

        $social = $input['social'];
        foreach ($social as $key => $value) {
            $s = [$key => $value];
            array_push($allsocial, $s);
        }

        DB::beginTransaction();
        $campaign = campaign::create([
            'name' => $input['name'],
            'description' => $input['description'],
            'social_handle' => json_encode($allsocial, JSON_UNESCAPED_SLASHES)
        ]);

        $campaign->users()->attach($user);
        $update = DB::table('campaigns_users')->where('campaign_id', $campaign->id)->update(['campaign_creator' => 1]);


        DB::commit();
        return $campaign;


    }

    public function addteam($campaign_id, $input)
    {

        $social=[];
        $campaign = campaign::find($campaign_id);
        foreach ($input['user'] as $key => $value) {

            foreach($input['social'] as $id=>$site){

                if($id==$key){

                    foreach($site as $link=>$value2){

                        $s=[$link=>$value2];
                        array_push($social,$s);
                    }
                    $json=json_encode($social,JSON_UNESCAPED_SLASHES);
                }
            }


            $existing_user = User::where('name', $value['name'])->where('email', $value['email'])->get();
            $count = count($existing_user);
            if ($count == 0 || empty($existing_user)) {

                $user = User::create([
                    'name' => $value['name'],
                    'email' => $value['email'],
                    'password' => bcrypt('password'),
                    'social_link' => $json
                ]);

                $campaign_user = $campaign->users()->attach($user);
                $update = DB::table('campaigns_users')->where('campaign_id', $campaign->id)->update(['role' => $value['role']]);


                return $user;

            } else {

                $user = $existing_user[0];

                if (isset($value['social'])) {


                    $social = $value['social'];
                    $json = json_encode($social, JSON_UNESCAPED_SLASHES);

                    //   $social=explode(',',$value['social']);

//                foreach($social as $soc){
//                    $handle=('')
//                }
                    //  return $value[$social;

                }
                $user->social_link=$json;
                $user->save();
                $campaign_user = $campaign->users()->attach($user);
                return $user;

            }
        }


    }

    public function budget($campaign_id, $input)
    {

        $budgetbreakup = [];

        foreach ($input['budget'] as $item => $value) {
            $array = [$item => $value];
            array_push($budgetbreakup, $array);
        }
        $json = json_encode($budgetbreakup, JSON_UNESCAPED_SLASHES);

        $campaign = campaign::find($campaign_id);
        $campaign->fill(['total_budget' => $input['total_budget'], 'budget' => $json, 'days' => $input['days']]);
        $campaign->save();
        return $campaign;
    }



    public function wip($campaign_id,$input){

        $campaign=campaign::find($campaign_id);


        if(isset($input['image'])){


           $imageSrc = Image::make(\Request::file('image'));
           $file_data = file_get_contents(\Request::file('image')->getRealPath());

           $imageobj=\App\Models\Image\Image::create([

              'mimeType'=>$imageSrc->mime(),
             //  'size'=>$imageSrc->size(),
               'data'=>$file_data

           ]);

           $campaign->image()->save($imageobj);

       }

        if(isset($input['file'])){


           $file_data = file_get_contents(\Request::file('file')->getRealPath());

            $mime=Input::file('file')->getMimeType();

           $imageobj=\App\Models\Image\Image::create([

              'mimeType'=>$mime,
             //  'size'=>$imageSrc->size(),
               'data'=>$file_data

           ]);


           $campaign->image()->save($imageobj);

       }



        $social=json_decode($campaign->social_handle);

        $weblink=explode(',',$input['weblink']);

        foreach ($weblink as $link){

            $linkarray=['weblink'=>$link];
            array_push($social,$linkarray);
        }
        $json_social=json_encode($social);

        $campaign->fill(['social_handle'=>$json_social]);
        $campaign->save();


        return $campaign;

    }


     public function projectinfo($campaign_id,$input){

          $campaign=campaign::find($campaign_id);

          $faqs=json_decode($campaign->faq);


        foreach ($input['faq'] as $id=>$question) {

            if ($id==1) {

                foreach ($question as $quest => $answer) {
                    {

                        $faqs[0]->answer = $answer;


                    }
                }
            }

            else if ($id==2) {

                foreach ($question as $quest => $answer) {

                    {
                        $faqs[1]->answer = $answer;

                    }
                }
            }
            else{

                foreach ($question as $quest => $answer) {
                    $array=['id'=>$id,'question'=>$quest,'answer'=>$answer];
                    array_push($faqs,$array);
                }

            }

        }
         $json=  json_encode($faqs);

        $campaign->fill(['about'=>$input['about'],'faq'=>$json]);

        $campaign->save();

        return $campaign;

         




    }
}