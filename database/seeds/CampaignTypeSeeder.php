<?php

use Illuminate\Database\Seeder;

class CampaignTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $campaign_type=[

            [
                'id'=>1,
                'type'=>'music',
                'tags'=>'music,dance,entertainment',
                'campaign_count'=>2
            ]

        ];

        DB::table('campaign_type')->insert($campaign_type);
    }
}
