<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('user_message')){
            Schema::create('user_message', function (Blueprint $table){
                $table->increments('id');
                $table->integer('campaign_id')->unsigned();
                $table->foreign('campaign_id')->references('id')->on('campaign')->onUpdate('cascade')->onDelete('cascade');
                $table->integer('sender_id')->unsigned();
                $table->foreign('sender_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
                $table->longText('reciepent_id');
               // $table->foreign('reciepent_id')->references('id')->on('users')->onUpdate('cascade')->onUpdate('cascade');
                $table->longText('message');
                $table->timestamps();
               });
            }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_message');
    }
}
