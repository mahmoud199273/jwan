<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_areas', function (Blueprint $table) {
            $table->increments('id');

                $table->integer('campaign_id')->unsigned()->nullable();
                 
                $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
                


                $table->integer('area_id')->unsigned()->nullable();
                 
                $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');



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
        Schema::dropIfExists('campaign_areas');
    }
}
