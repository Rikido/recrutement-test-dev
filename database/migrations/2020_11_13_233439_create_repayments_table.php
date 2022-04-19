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
            $table->Increments('id');//シーケンスID
            $table->string('payment_month');//入金対象月
            $table->integer('trade_id')->unsigned();//掛取引id
            $table->foreign('trade_id')->references('id')->on('trades');//掛取引id
            $table->integer('amount');//入金額
            $table->string('delay_flag');//遅延フラグ
            $table->integer('credit_minus');//遅延が発生した際の信用スコアの減点点数
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
