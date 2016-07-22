<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CampaignSuccessTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::dropIfExists('campaign_success_transaction');
        Schema::create('campaign_success_transaction',function (Blueprint $table){

            $table->increments('id');
            $table->integer('campaign_id')->unsigned();
            $table->foreign('campaign_id')->references('id')->on('campaign')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('transaction_id')->unsigned();
            $table->foreign('transaction_id')->references('id')->on('transactions')->onUpdate('cascade')->onDelete('cascade');
//            $table->integer('reward_id')->unsigned();
//            $table->foreign('reward_id')->references('id')->on('rewards')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('amount');

            $table->index('amount');
            $table->index('campaign_id');
         //   $table->boolean('is_refunded');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::drop('transaction_success');
    }
}
