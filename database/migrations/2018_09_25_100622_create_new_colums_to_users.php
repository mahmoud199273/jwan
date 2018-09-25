<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewColumsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table) {

             $table->dropColumn('nationality');

             $table->integer('nationality_id')->after('gender')->unsigned()->nullable();
             
             $table->foreign('nationality_id')->references('id')->on('nathionalities')->onUpdate('set null')->onDelete('set null');





            /*$table->integer('countries_id')->unsigned()->nullable();
            $table->foreign('countries_id')->references('id')->on('countries')->onUpdate('set null')->onDelete('set null');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
