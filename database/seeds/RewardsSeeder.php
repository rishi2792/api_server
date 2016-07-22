<?php

use Illuminate\Database\Seeder;

class RewardsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $camp_id=DB::table('campaign')->distinct()->lists('id');
        $faker=\Faker\Factory::create();
        for($i=0;$i<=50;$i++){

            $reward=\App\Models\rewards::create([
                'name'=>$faker->name,
                'descprition'=>$faker->text(),
                'amount'=>$faker->numberBetween(1000,100000),
                'is_pledged'=>$faker->boolean(),
                'reward_count'=>$faker->randomNumber(),
                'limit'=>$faker->randomDigit,
                'shipping_estimate_date'=>$faker->date(),
                'campaign_id'=>$camp_id[array_rand($camp_id)]

            ]);


        }
    }
}
