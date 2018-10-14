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

            $table->enum('status',[0,1,2,3,4,5,6,7]);

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
