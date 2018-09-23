<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            $table->increments('id');
            
            $table->string('email')->unique()->nullable();

            $table->string('phone')->unique()->index();
            
            $table->string('password');

            $table->string('image')->nullable();

            $table->string('name')->nullable();

            $table->enum('gender',[0,1])->nullable(); // male OR female

            $table->string('nationality')->nullable();

            $table->longtext('notes')->nullable();

            $table->enum('account_manger',[0,1])->nullable();

            
            $table->enum('type',[0,1,2])->nullable(); //government OR personal OR company

            $table->enum('is_active',[0,1])->nullable();
             
            
            
            $table->string('video')->nullable();

            $table->string('facebook')->nullable();
            $table->integer('facebook_follwers')->nullable();

            $table->string('twitter')->nullable();
            $table->integer('twitter_follwers')->nullable();

            $table->string('instgrame')->nullable();
            $table->integer('instgrame_follwers')->nullable();

            $table->string('snapchat')->nullable();
            $table->integer('snapchat_follwers')->nullable();

            $table->string('linkedin')->nullable();
            $table->integer('linkedin_follwers')->nullable();

            $table->string('youtube')->nullable();
            $table->integer('youtube_follwers')->nullable();

            

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
