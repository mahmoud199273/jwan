<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAboutAppTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('about_app', function (Blueprint $table) {

            $table->increments('id');

            $table->longText('body');
            $table->longText('body_ar');

            $table->string('fb_link');
            $table->string('twitter_link');

            $table->string('google_link');

            $table->string('insta_link');
            $table->string('snap_link');

            $table->string('privacy_title');

            $table->string('privacy_title_ar');


            $table->longText('privacy_policy');

            $table->longText('privacy_policy_ar');


            $table->string('influncer_privacy_title');

            $table->longText('influncer_privacy_policy');


            $table->string('influncer_privacy_title_ar');

            $table->longText('influncer_privacy_policy_ar');
            
            
            

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
        Schema::dropIfExists('about_app');
    }
}
