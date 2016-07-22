<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CampaignType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('campaign_type')) {
            Schema::create('campaign_type', function (Blueprint $table) {
                $table->increments('id');
                $table->string('type');
                $table->longText('tags');
                $table->integer('campaign_count');
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
       Schema::drop('campaign_type');
    }
}
