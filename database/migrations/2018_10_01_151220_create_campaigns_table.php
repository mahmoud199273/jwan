<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');

            $table->integer('user_id')->unsigned()->nullable();
             
             $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

             $table->enum('facebook',[0,1]);

             $table->enum('twitter',[0,1]);

             $table->enum('snapchat',[0,1]);

             $table->enum('youtube',[0,1]);

             $table->enum('instgrame',[0,1]);

             $table->enum('male',[0,1]);

             $table->enum('female',[0,1]);

             $table->enum('general',[0,1]);

             $table->longText('description');

             $table->longText('scenario');

             $table->integer('maximum_rate');

             $table->dateTime('created_date');

             $table->dateTime('updated_date');

             $table->enum('campaign_status',[0,1,2,3,4,5,6,7,8,9]);

            // 0 = new
            // 1 = approved
            // 2 = rejected
            // 3 = in progress
            // 4 = Pending proof
            // 5 = Pending payment
            // 6 = Confirmed
            // 7 = finished
            // 8 = canceled
            // 9 = closed

             

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
        Schema::dropIfExists('campaigns');
    }
}
