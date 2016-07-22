<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Campaign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('campaign');
        Schema::create('campaign', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->longText('description');
            $table->longText('about');
            $table->longText('faq');
            $table->integer('days');
            $table->longText('budget');
            $table->longText('social_handle');
            $table->string('status');
            $table->string('contributer_message');
            $table->boolean('is_locked');
            $table->boolean('is_active');
            $table->date('live_date');
            $table->string('location');
            $table->integer('amount_raised');
            $table->bigInteger('total_budget');


       //foreign key

//            $table->integer('type_id')->unsigned();
//            $table->foreign('type_id')->references('id')->on('campaign_type')->onUpdate('cascade')->onDelete('cascade');
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
       Schema::drop('campaign');
    }
}
