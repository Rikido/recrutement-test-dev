<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResourceStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resource_stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreign('location_id')->reference('id')->on('locations');
            $table->foreign('resource_id')->reference('id')->on('resources');
            $table->integer('stock');
            $table->integer('weight');
            $table->integer('size');
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
        Schema::dropIfExists('resource_stocks');
    }
}
