<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSocialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('user_social_medias')) {
            Schema::create('user_social_medias', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->string('social_service');
                $table->bigInteger('social_service_id');
                $table->foreign('user_id')->references('id')->on('users');
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
        Schema::drop('user_social_medias');
    }
}
