<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Transactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('transactions');
        Schema::create('transactions',function (Blueprint $table){


            $table->increments('id');
            $table->integer('reward_id')->unsigned();
            $table->foreign('reward_id')->references('id')->on('rewards')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('campaign_id')->unsigned();
            $table->foreign('campaign_id')->references('id')->on('campaign')->onUpdate('cascade')->onDelete('cascade');
            $table->string('status');
            $table->string('currency');
            $table->boolean('is_successful');
            $table->integer('amount');
            $table->string('campaign_awareness');
            $table->string('payment_gateway');
            $table->integer('payment_gateway_id');
            $table->boolean('is_anonymous');
            $table->boolean('is_refunded');
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
        Schema::drop('transactions');
    }
}
