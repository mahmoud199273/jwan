<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_categories', function (Blueprint $table) {

            $table->increments('id');


            $table->integer('user_id')->unsigned()->nullable();
             
             $table->foreign('user_id')->references('id')->on('users')->onUpdate('set null')->onDelete('set null');
            


            $table->integer('categories_id')->unsigned()->nullable();
             
             $table->foreign('categories_id')->references('id')->on('categories')->onUpdate('set null')->onDelete('set null');

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
        Schema::dropIfExists('user_categories');
    }
}
