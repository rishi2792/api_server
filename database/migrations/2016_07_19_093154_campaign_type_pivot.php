<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CampaignTypePivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('campaign_type_pivot')) {
            Schema::create('campaign_type_pivot', function (Blueprint $table) {

                $table->increments('id');
                $table->integer('campaign_type_id')->unsigned();
                $table->foreign('campaign_type_id')->references('id')->on('campaign_type')->onUpdate('cascade')->onDelete('cascade');
                $table->integer('campaign_id')->unsigned();
                $table->foreign('campaign_id')->references('id')->on('campaign')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::drop('campaign_type_pivot');
    }
}
