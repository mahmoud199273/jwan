<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {

            $table->increments('id');

            $table->integer('influncer_id')->unsigned()->nullable();
             
            $table->foreign('influncer_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('user_id')->unsigned()->nullable();
             
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('campaign_id')->unsigned()->nullable();
                 
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');

            $table->string('cost');

            $table->longText('description');

            $table->enum('status',[0,1,2,3,4,5,6,7,8,9]);
            // 0 new - offer added by influencer
            // 1 approved - by user --- > approve
            // 2 refused - by user
            // 3 pay - by user
            // 4 in progress - by influencer
            // 5 proof submitted - by influencer
            // --- 6 proof accepted - by user no need
            // 7 finish/done
            // 8 Canceled by influncer
            // 9 canceled by user


            $table->softDeletes();

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
        Schema::dropIfExists('offers');
    }
}
