<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Image extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('image');
        Schema::create('image',function (Blueprint $table){
            $table->increments('id');
            $table->string('mimeType');
            $table->bigInteger('size');
            $table->morphs('imageable');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE image ADD data MEDIUMBLOB");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('image');
    }
}
