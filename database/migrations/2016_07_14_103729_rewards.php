<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Rewards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('rewards');
        Schema::create('rewards',function (Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('descprition');
            $table->bigInteger('amount');
            $table->boolean('is_pledged');
            $table->integer('reward_count');
            $table->integer('limit');
            $table->date('shipping_estimate_date');

            $table->integer('campaign_id')->unsigned();

            $table->foreign('campaign_id')->references('id')->on('campaign')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::drop('rewards');
    }
}
