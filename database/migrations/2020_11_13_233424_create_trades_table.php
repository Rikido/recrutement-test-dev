<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->Increments('id');//シーケンスID
            $table->integer('transaction_amount');//取引額
            $table->integer('transaction_balance');//未回収金額
            $table->integer('months_of_term');//返済期間月数
            $table->integer('client_id')->unsigned();//取引先id
            $table->foreign('client_id')->references('id')->on('clients');//取引先id
            $table->integer('trade_score');//取引ごとの信用スコア（これを加重平均することでcredit_scoreを算出する）
            $table->timestamps();//作成日時、更新日時
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trades');
    }
}
