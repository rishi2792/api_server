<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $social = array('facebook'=>'https://www.facebook.com/wishberry.in','twitter'=>'https://www.twitter.com/wishberry.in');
        $social_json=json_encode($social,JSON_UNESCAPED_SLASHES);

        $budget=['camera'=>2000,'production'=>3000];
        $budget_json=json_encode($budget,JSON_UNESCAPED_SLASHES);


        $faker = Faker\Factory::create();


        for($i=1;$i<=200;$i++) {
            $campaign = \App\Models\campaign::create([
                'name' => $faker->name,
                'description' => $faker->text(250),
                'about' => $faker->text(200),
                'faq' => $faker->text(250),
                'days' => $faker->numberBetween(0, 60),
                'budget' => $budget_json,

                'social_handle' => $social_json,
                'status' => $faker->name,
               // 'comment' => $faker->text(50),
                'is_locked' => 1,
                'is_active' => 0,
                'live_date' => Carbon::now(),
                'location' => $faker->city,
                'amount_raised' => $faker->numberBetween(5000, 50000),
                'total_budget' => $faker->numberBetween(500000, 500000),


            ]);
        }


    }
}
