<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Repayment;
use App\Models\Trade;
use App\Models\Client;

class RepaymentsController extends Controller
{
    //
    public function index_repayments()
    {
        if(!auth() ->check()){
          return redirect('login');
        }

        $repayments = Repayment::with('trades')->paginate(5);
        return view('/repayments/index_repayments', [
          'repayments' => $repayments
        ]);
    }

    public function add_repayments($id)
    {
        if(!auth() ->check()){
          return redirect('login');
        }
        $trade = Trade::find($id);
        $client = Client::find($trade->client_id);

        return view('/repayments/add_repayments',  [
          'id' => $id,
          'trade' => $trade,
          'client' => $client,
      ]);
    }

      public function register($id, Request $request)
      {

          $trade = Trade::find($id);
          $client = Client::find($trade->client_id);
          $must_be_amount = ceil($trade->transaction_amount/$trade->months_of_term);
          $must_be_int_amount = intval($must_be_amount);
        
          $request->validate([
            'trade_id' => 'required',
            'payment_month' => 'required',
            'amount' => "integer|lte:{$must_be_int_amount}|gte:{$must_be_int_amount}",
            'delay_flag' => 'required',
          ]);
          
          Repayment::create($request->all());

          //tradesのtransaction_balanceへの反映
          $trade->transaction_balance = $trade->transaction_balance - $request->amount;
          $trade->save();

          //月次返済処理時のtrade_scoreの更新
          if ($request->delay_flag=="yes"){
            $trade->trade_score=$trade->trade_score + $request->credit_minus;
            $trade->save();
          }
        
          //上記でtradesに反映後、clientsのcredit_scoreにも反映
          $trades_count=Trade::where('client_id', $client->id)
                 ->count();
          
          if ($trades_count==0){
            $first_trade_score=65;
            $sum_transaction_balance=0;
          }
          else{
            $first_trade=Trade::where('client_id', $client->id)
                        ->orderBy('created_at', 'desc')
                        ->first();
            $first_trade_score=$first_trade->trade_score;
            $sum_transaction_balance=Trade::where('client_id', $client->id)
                                    ->sum('transaction_balance');
          }
  
          if ($trades_count<=1){
            $second_trade_score=65;
          }
          else{
            $second_trade=Trade::where('client_id', $client->id)
                         ->where('id', '<', $first_trade->id)
                         ->orderBy('created_at', 'desc')
                         ->first();
            $second_trade_score=$second_trade->trade_score;
          }
  
          if ($trades_count<=2){
            $third_trade_score=65;
          }
          else{
            $third_trade=Trade::where('client_id', $client->id)
                        ->where('id', '<', $second_trade->id)
                        ->orderBy('created_at', 'desc')
                        ->first();
            $third_trade_score=$third_trade->trade_score;
          }
           
          $client->credit_score = $first_trade_score*0.5 + $second_trade_score*0.3 + $third_trade_score*0.2;
          $client->account_receivable_balance = $sum_transaction_balance;
          $client->save();
  
          
          return redirect('/');
      }
  
      public function update($id, Request $request, Repayment $repayment)
      {
        $request->validate([
          'trade_id' => 'required',
          'payment_month' => 'required',
          'amount' => 'required',
          'delay_flag' => 'required',
        ]);
  
          if(!auth() ->check()){
            return redirect('login');
          }
  
          $repayment = Repayment::find($id);
          $repayment->trade_id = $request->trade_id;
          $repayment->payment_month = $request->payment_month;
          $repayment->amount = $request->amount;
          $repayment->delay_flag = $request->delay_flag;
          $repayment->save();

          return redirect('/');
      }
  
      public function destroy_confirm($id)
      {
          if(!auth() ->check()){
            return redirect('login');
          }
  
          $repayment = Repayment::find($id);
          $trade = Trade::find($repayment->trade_id);
          $client = Client::find($trade->client_id);
  
          return view('/repayments/destroy_repayments_confirm',  [
            'id' => $id,
            'repayment' => $repayment,
            'trade' => $trade,
            'client' => $client,
          ]);
      }
  
      public function destroy($id, Request $request, Repayment $repayment)
      {
          if(!auth() ->check()){
            return redirect('login');
          }

          //各データを特定
          $repayment = Repayment::find($id);
          $trade = Trade::find($repayment->trade_id);
          $client = Client::find($trade->client_id);

          //tradesのtransaction_balanceの修正
          $trade->transaction_balance = $trade->transaction_balance + $repayment->amount;
          $trade->save();

          //月次返済処理時のtrade_scoreの更新
          if($request->delay_flag="yes"){
            $trade->trade_score = $trade->trade_score - $repayment->credit_minus;
            $trade->save();
          }

          //repayment削除
          $repayment->delete();

          //trade_scoreの値変更をcredit_scoreにも反映
          $trades_count=Trade::where('client_id', $client->id)
                 ->count();
          
          if ($trades_count==0){
            $first_trade_score=65;
            $sum_transaction_balance=0;
          }
          else{
            $first_trade=Trade::where('client_id', $client->id)
                 ->orderBy('created_at', 'desc')
                 ->first();
            $first_trade_score=$first_trade->trade_score;
            $sum_transaction_balance=Trade::where('client_id', $client->id)
                                    ->sum('transaction_balance');
          }
  
          if ($trades_count<=1){
            $second_trade_score=65;
          }
          else{
            $second_trade=Trade::where('client_id', $client->id)
                         ->where('id', '<', $first_trade->id)
                         ->orderBy('created_at', 'desc')
                         ->first();
            $second_trade_score=$second_trade->trade_score;
          }
  
          if ($trades_count<=2){
            $third_trade_score=65;
          }
          else{
            $third_trade=Trade::where('client_id', $client->id)
                        ->where('id', '<', $second_trade->id)
                        ->orderBy('created_at', 'desc')
                        ->first();
            $third_trade_score=$third_trade->trade_score;
          }
           
           $client->credit_score = $first_trade_score*0.5 + $second_trade_score*0.3 + $third_trade_score*0.2;
           $client->account_receivable_balance = $sum_transaction_balance;
           $client->save();
  
          return redirect('/');
      }

}
