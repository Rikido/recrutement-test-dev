<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Trade;
use App\Models\Client;
use App\Models\Repayment;

class TradesController extends Controller
{
    //
    public function index_trades()
    {
        if(!auth() ->check()){
          return redirect('login');
        }

        $trades = Trade::with('clients')->paginate(5);
        $repayments = Repayment::with('trades');

        return view('/trades/index_trades', [
          'trades' => $trades,
          'repayments' => $repayments,
        ]);
    }

    public function add_trades($id)
    {
        if(!auth() ->check()){
          return redirect('login');
        }

        $client = Client::find($id);

        return view('/trades/add_trades',  [
            'id' => $id,
            'client' => $client,
        ]);
    }

    public function register($id, Request $request)
    {

        $client = Client::find($id);
        $able_balance = $client->credit_line - $client->account_receivable_balance;
        
        $request->validate([
            'client_id' => 'required',
            'transaction_amount' => "required|integer|lte:{$able_balance}",
            'months_of_term' => 'required|digits_between:1,2|lte:84',
        ]);
        
        $request->request->add(['transaction_balance'=>$request->transaction_amount]);
        Trade::create($request->all());

        //clientsのcredit_scoreへの反映
        $trades_count=Trade::where('client_id', $id)
               ->count();
        
        //clientに紐づく最新のtradeを3件取得
        if ($trades_count==0){
          $first_trade_score=65;
          $first_transaction_amount=0;
          $sum_transaction_balance=0;
        }
        else{
          $first_trade=Trade::where('client_id', $id)
               ->orderBy('created_at', 'desc')
               ->first();
          $first_trade_score=$first_trade->trade_score;
          $first_transaction_amount=$first_trade->transaction_amount;
          $sum_transaction_balance=Trade::where('client_id', $id)
                                  ->sum('transaction_balance');
        }

        if ($trades_count<=1){
          $second_trade_score=65;
          $second_transaction_amount=0;
        }
        else{
          $second_trade=Trade::where('client_id', $id)
                       ->where('id', '<', $first_trade->id)
                       ->orderBy('created_at', 'desc')
                       ->first();
          $second_trade_score=$second_trade->trade_score;
          $second_transaction_amount=$second_trade->transaction_amount;
        }

        if ($trades_count<=2){
          $third_trade_score=65;
          $third_transaction_amount=0;
        }
        else{
          $third_trade=Trade::where('client_id', $id)
                      ->where('id', '<', $second_trade->id)
                      ->orderBy('created_at', 'desc')
                      ->first();
          $third_trade_score=$third_trade->trade_score;
          $third_transaction_amount=$third_trade->transaction_amount;
        }

        //clientsに反映
        $client->credit_score = $first_trade_score*0.5 + $second_trade_score*0.3 + $third_trade_score*0.2;
        $client->credit_line = ($client->capital_amount*0.1*0.3 + ($client->annual_sales_1*0.5 + $client->annual_sales_2*0.3 + $client->annual_sales_3*0.2)*0.4*0.3 + ($first_transaction_amount*0.5 + $second_transaction_amount*0.3 + $third_transaction_amount*0.2)*0.4)*$client->credit_score/100;
        $client->account_receivable_balance = $sum_transaction_balance;
        $client->save();

        return redirect('/');
    }

    public function update($id, Request $request, Trade $trade)
    {
      $request->validate([
        'client_id' => 'required',
        'transaction_amount' => 'required||digits_between:1,13',
        'months_of_term' => 'required||digits_between:1,2||max:84',
      ]);

        if(!auth() ->check()){
          return redirect('login');
        }

        $trade = Trade::find($id);
        $trade->client_id = $request->client_id;
        $trade->transaction_amount = $request->transaction_amount;
        $trade->months_of_term = $request->months_of_term;
        $trade->save();

        return redirect('/');
    }

    public function destroy_confirm($id)
    {
        if(!auth() ->check()){
          return redirect('login');
        }

        $trade = Trade::find($id);

        return view('/trades/destroy_trades_confirm',  [
          'id' => $id,
          'trade' => $trade
        ]);
    }

    public function destroy($id, Request $request, Trade $trade)
    {
        if(!auth() ->check()){
          return redirect('login');
        }

        $trade = Trade::find($id);
        $trade->delete();
        $client = Client::find($trade->client_id);

        //clientsのcredit_scoreへの反映
        $trades_count=Trade::where('client_id', $id)
               ->count();
        
        //clientに紐づく最新のtradeを3件取得
        if ($trades_count==0){
          $first_trade_score=65;
          $first_transaction_amount=0;
          $sum_transaction_balance=0;
        }
        else{
          $first_trade=Trade::where('client_id', $id)
                      ->orderBy('created_at', 'desc')
                      ->first();
          $first_trade_score=$first_trade->trade_score;
          $first_transaction_amount=$first_trade->transaction_amount;
          $sum_transaction_balance=Trade::where('client_id', $id)
                                  ->sum('transaction_balance');
        }

        if ($trades_count<=1){
          $second_trade_score=65;
          $second_transaction_amount=0;
        }
        else{
          $second_trade=Trade::where('client_id', $id)
                       ->where('id', '<', $first_trade->id)
                       ->orderBy('created_at', 'desc')
                       ->first();
          $second_trade_score=$second_trade->trade_score;
          $second_transaction_amount=$second_trade->transaction_amount;
        }

        if ($trades_count<=2){
          $third_trade_score=65;
          $third_transaction_amount=0;
        }
        else{
          $third_trade=Trade::where('client_id', $id)
                      ->where('id', '<', $second_trade->id)
                      ->orderBy('created_at', 'desc')
                      ->first();
          $third_trade_score=$third_trade->trade_score;
          $third_transaction_amount=$third_trade->transaction_amount;
        }

        //加重平均を行い、credit_scoreに反映
        $client->credit_score = $first_trade_score*0.5 + $second_trade_score*0.3 + $third_trade_score*0.2;
        $client->credit_line = ($client->capital_amount*0.1*0.3 + ($client->annual_sales_1*0.5 + $client->annual_sales_2*0.3 + $client->annual_sales_3*0.2)*0.4*0.3 + ($first_transaction_amount*0.5 + $second_transaction_amount*0.3 + $third_transaction_amount*0.2)*0.4)*$client->credit_score/100;
        $client->account_receivable_balance = $sum_transaction_balance;
        $client->save();

        return redirect('/');
    }
}
