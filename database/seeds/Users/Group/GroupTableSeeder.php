<?php namespace seeds\Users\Group;
/**
 * Created by PhpStorm.
 * User: atul
 * Date: 3/21/2016
 * Time: 12:17 AM
 */

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\User\Group;

class GroupTableSeeder extends Seeder
{
    public function run()
    {
        $groups=[
            [
                "description"=>"Remote Players",
                "access"=>"remote"
            ],
            [
                "description"=>"Proxy Players",
                "access"=>"proxy",
            ],
            [
                "description"=>"Administrator",
                "access"=>"admin",
            ]
        ];

        foreach ($groups as $group) {
            $groupObj=Group::create([
                "name"=>$group["access"],
                "description"=>$group["description"],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}