<?php

use Illuminate\Database\Seeder;

class StransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $trans=\App\Models\transaction::where('is_successful',1)->get();

        foreach($trans as $tran){

           DB::table('campaign_success_transaction')->insert(['campaign_id'=>$tran->campaign_id,'transaction_id'=>$tran->id,'amount'=>$tran->amount]);


        }
    }
}
