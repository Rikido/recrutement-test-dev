<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repayments', function (Blueprint $table) {
            $table->bigIncrements('id');//シーケンスID
            $table->integer('payment_month');//入金対象月
            $table->integer('trade_id')->unsigned();//掛取引id
            $table->foreign('trade_id')->references('id')->on('trades');//掛取引id
            $table->integer('amount');//入金額
            $table->boolean('delay_flag');//遅延フラグ
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
        Schema::dropIfExists('repayments');
    }
}
