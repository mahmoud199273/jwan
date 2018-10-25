<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInfluncerCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('influncer_campaigns', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('influncer_id')->unsigned()->nullable();
             
            $table->foreign('influncer_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('campaign_id')->unsigned()->nullable();
                 
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');

            $table->enum('status',[0,1]);

            // 0 = skip    1= favorite 


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
        Schema::dropIfExists('influncer_campaigns');
    }
}
