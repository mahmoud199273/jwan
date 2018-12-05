<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSocialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_socials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('facebook')->nullable();
            $table->integer('facebook_followers')->nullable();

            $table->string('twitter')->nullable();
            $table->integer('twitter_followers')->nullable();

            $table->string('instagram')->nullable();
            $table->integer('instagram_followers')->nullable();

            $table->string('snapchat')->nullable();
            $table->integer('snapchat_followers')->nullable();

            $table->string('linkedin')->nullable();
            $table->integer('linkedin_followers')->nullable();

            $table->string('youtube')->nullable();
            $table->integer('youtube_followers')->nullable();
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
        Schema::dropIfExists('user_socials');
    }
}
