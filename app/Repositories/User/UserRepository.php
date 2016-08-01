<?php
/**
 * Created by PhpStorm.
 * User: ATUL
 * Date: 3/19/2016
 * Time: 6:13 PM
 */

namespace App\Repositories\User;

use App\Models\campaign;
use App\Models\transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserRepository implements UserRepositoryInterface
{
    protected $user;



    public function __construct(User $user)
    {
        $this->user=$user;
    }

    public function find($userId)
    {
        $user=$this->user->findOrFail($userId);
        return $user;
    }


    public function addinfo($user_id,$campaign_id,$reward_id,$input)
    {
        $user=$this->user->findOrFail($user_id);
        if($user){
            $array=[];
            $data=[];


            foreach ($input['shipping']as $key=>$value){

                $array=[$key=>$value];
                array_push($data,$array);



               // $array=['country'=>$key['country'],'pincode'=>$value['pincode'],'address'=>$value['address'],'city'=>$value['city'],'state'=>$value['state']];

            }

           $output= json_encode($data,JSON_UNESCAPED_SLASHES);

           $user->fill(['address'=>$output,'phone'=>$input['phone'],'wishberry_awareness'=>$input['wishberry_awareness']]);

           $user->save();

           $transaction=transaction::where('campaign_id',$campaign_id)->where('reward_id',$reward_id)->where('user_id',$user_id)->first();
            if(!$transaction){
                throw new ModelNotFoundException;

            }
            else{

                $transaction->fill(['status'=>'submitted','is_anonymous'=>$input['is_anonymous']]);
                $transaction->save();
            }
          return $user;


        }
    }


}