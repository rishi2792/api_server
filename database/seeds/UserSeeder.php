<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type=['pc','mobile'];


//        $login_detail = ['ip'=>long2ip(mt_rand()),'host_type'=>$type[array_rand($type)]];
//        $login_detail_json=json_encode($login_detail,JSON_UNESCAPED_SLASHES);

        $social = array('facebook'=>'https://www.facebook.com/wishberry.in','twitter'=>'https://www.twitter.com/wishberry.in');
        $social_json=json_encode($social,JSON_UNESCAPED_SLASHES);

        $faker = Faker\Factory::create();


        for($i=0;$i<=100;$i++) {
            $login_detail = ['ip'=>long2ip(mt_rand()),'host_type'=>$type[array_rand($type)]];
            $login_detail_json=json_encode($login_detail,JSON_UNESCAPED_SLASHES);

            $user = \App\Models\User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->email,
                'password' => bcrypt($faker->password(6, 9)),
                'login_detail' => $login_detail_json,
                'last_seen' => $faker->dateTime,
                'social_link' => $social_json,
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'prefrence' => 1,
                'wishberry_awareness' => "internet"
            ]);

        }

    }
}
