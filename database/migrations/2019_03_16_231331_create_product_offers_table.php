<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_offers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_en')->nullable();
            $table->string('title_ar')->nullable();
            $table->longtext('desc_en')->nullable();
            $table->longtext('desc_ar')->nullable();
            $table->string('image')->nullable();
            $table->string('price')->nullable();
            $table->integer('qnt')->nullable();
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
        Schema::dropIfExists('product_offers');
    }
}
