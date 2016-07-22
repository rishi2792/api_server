<?php

use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


   

        \Illuminate\Database\Eloquent\Model::unguard();
        $camp_id=DB::table('campaign')->distinct()->lists('id');
        $user_id=DB::table('users')->distinct()->lists('id');
        $reward_id=DB::table('rewards')->distinct()->lists('id');

        $amount=['1500','2000'];
        $faker = Faker\Factory::create();
        for($i=0;$i<=1000;$i++){
         $transaction=\App\Models\transaction::create([
             'reward_id'=>$reward_id[array_rand($reward_id)],
              'user_id'=>$user_id[array_rand($user_id)],
             'campaign_id'=>$camp_id[array_rand($camp_id)],
              'status'=>$faker->text,
             'currency'=>$faker->currencyCode,
             'is_successful'=>$faker->boolean(),
             'campaign_awareness'=>$faker->text,
             'payment_gateway'=>$faker->domainName,
             'payment_gateway_id'=>$faker->randomDigit,
             'amount'=>$faker->numberBetween(2000,30000),
             'is_anonymous'=>$faker->boolean()


         ]);


        }
    }
}
