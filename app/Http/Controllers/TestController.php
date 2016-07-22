<?php

namespace App\Http\Controllers;

use App\Models\campaign;
use App\Models\campaign_type;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\BaseController;
use Faker;
use Carbon\Carbon;
use DB;

class TestController extends BaseController
{
    public function index()
    {
       return "Hello World !";

    }

    public function test3()
    {
        $campaign=campaign::find(1);
        $today=strtotime(date('Y-m-d'));
        $live_date=strtotime($campaign->live_date);
        $diff=($today-$live_date);
      return  $days= floor($diff/60*60*24);


        $t=($d-$b);
       $c= round($t/86400);
            $daysleft=round(strtotime(date('Y-m-d')-strtotime($campaign->live_date))/86400);

          return    $a=$campaign->days-$c;

        $campaign=campaign::find(1);
       $users = $campaign->creator;
          $user=$users[0];
        return $user->name;

       //  $target=DB::table('campaign')->where('id',4)->pluck('total_budget');

        $camp_id=DB::table('campaign')->distinct()->lists('id');
        $user_id=DB::table('users')->distinct()->lists('id');
        $reward_id=DB::table('rewards')->distinct()->lists('id');

       // $amount=['1500','2000'];
        $faker = Faker\Factory::create();
        for($i=0;$i<=1000;$i++){
            $transaction=\App\Models\transaction::create([
                'reward_id'=>$reward_id[array_rand($reward_id)],
                'user_id'=>$user_id[array_rand($user_id)],
                'campaign_id'=>$camp_id[array_rand($camp_id)],
                'status'=>$faker->sentences(),
                'currency'=>$faker->currencyCode,
                'is_sucessful'=>$faker->boolean(),
                'campaign_awareness'=>$faker->text,
                'payment_gateway'=>$faker->domainName,
                'payment_gateway_id'=>$faker->randomNumber(),
                'amount'=>$faker->numberBetween(2000,300000),
                'is_anonymous'=>$faker->boolean()


            ]);


        }











//        $camp_id=DB::table('campaign')->distinct()->lists('id');
//      return  $a=$camp_id[array_rand($camp_id)];
//
//               return  $id= DB::table('campaign')->select('id')->get();
//        return     $b=array_column($id,'id');
//
//
//        $a=DB::table('campaign')->where('id',1)->get();
//
//            $users2 = DB::connection('mysql2');
//// Getting data with second DB object.
//       // $u = $users2->table('admin_users')->insert(['name'=>'rishi','email'=>'rishi@test.com','password'=>bcrypt('password')]);
//    return $u= $users2->table('admin_users')->get();





    }

}
