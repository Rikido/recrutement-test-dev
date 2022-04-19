<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->Increments('id');//シーケンスID
            $table->string('client_name', 50);//取引先名
            $table->integer('capital_amount');//資本金額
            $table->integer('annual_sales_1');//売上高_前期
            $table->integer('annual_sales_2');//売上高_前々期
            $table->integer('annual_sales_3');//売上高_前々々期
            $table->integer('credit_score');//信用スコア
            $table->integer('credit_line');//貸付枠
            $table->integer('account_receivable_balance');//未回収掛売残高
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
        Schema::dropIfExists('clients');
    }
}
