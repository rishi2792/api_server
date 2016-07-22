<?php
/**
 * Created by PhpStorm.
 * User: ATUL
 * Date: 3/19/2016
 * Time: 9:12 PM
 */

namespace seeds\Users;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\User\Group;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $remotePlayers=[
            [
                "name"=>"Admin User",
                "email"=>"superuser@demo.com",
            ],
        ];

        $faker = Faker::create();

        foreach ($remotePlayers as $player) {
            $user=User::create([
                "name"=>$player["name"],
                "email"=>$player["email"],
                "password"=>bcrypt("password"),
                "activation_code"=>$faker->bothify('??????????'),
                "is_active"=>1,
                "resent"=>0,
                "signup_ip_address"=>$faker->ipv4,
                "signup_confirmation_ip_address"=>$faker->ipv4,
                "signup_sm_ip_address"=>$faker->ipv4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            $group=Group::where('name','admin')->get();

            \DB::table('users_groups')->insert([
                'user_id' => $user->id,
                'group_id' => $group[0]->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}