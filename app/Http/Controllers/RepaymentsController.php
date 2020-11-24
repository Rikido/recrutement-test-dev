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

      public function register(Request $request)
      {
          $request->validate([
              'trade_id' => 'required',
              'payment_month' => 'required',
              'amount' => 'required',
              'delay_flag' => 'required',
              //あとは当日時点与信枠 / 未回収掛売り残高 / 貸付可能枠残高を考慮し別途バリデーション
              //delay_flag別途バリデーション
          ]);
          
          Repayment::create($request->all());
          
          return redirect('/');
      }
  
      public function edit($id)
      {
          if(!auth() ->check()){
            return redirect('login');
          }
  
          $repayment = Repayment::find($id);
          $trade = Trade::find($repayment->trade_id);
          $client = Client::find($trade->client_id);
  
          return view('/repayments/edit_repayments',  [
            'id' => $id,
            'repayment' => $repayment,
            'trade' => $trade,
            'client' => $client
          ]);
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
  
          $repayment = Repayment::find($id);
          $repayment->delete();
  
          return redirect('/');
      }

}
