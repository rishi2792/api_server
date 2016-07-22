<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exclude = [
            //'migrations'
            //Add Tables Names Which Needs To Be excluded During seeding
        ];

        $tables = [
            'users',
            'campaign',
            'transactions',
            'campaign_success_transaction',
            'rewards'
        ];

        DB::statement( 'SET FOREIGN_KEY_CHECKS=0' );
     /*   foreach (DB::select('SHOW TABLES') as $k => $v) {
            $tables[] = array_values((array)$v)[0];
        }*/
        foreach($tables as $table) {
            if (!in_array($table, $exclude)) {
                DB::table($table)->truncate();
            }
        }
        DB::statement( 'SET FOREIGN_KEY_CHECKS=1' );

        $this->call('seeds\OAuthClientSeeder');
        $this->call('CampaignTypeSeeder');
        $this->call('UserSeeder');

        $this->call('CampaignSeeder');
        $this->call('RewardsSeeder');
        $this->call('TransactionSeeder');
        $this->call('StransactionSeeder');








    }
}
