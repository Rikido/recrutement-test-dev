<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Trade;
use App\Models\Client;

class TradesController extends Controller
{
    //
    public function index_trades()
    {
        if(!auth() ->check()){
          return redirect('login');
        }

        $trades = Trade::with('clients')->paginate(5);

        return view('/trades/index_trades', [
          'trades' => $trades
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

    public function register(Request $request)
    {
        $request->validate([
            'client_id' => 'required',
            'transaction_amount' => 'required||digits_between:1,13',
            'months_of_term' => 'required||digits_between:1,2||max:84',
            //あとは当日時点与信枠 / 未回収掛売り残高 / 貸付可能枠残高を考慮し別途バリデーション
        ]);
        
        Trade::create($request->all());
        
        return redirect('/');
    }

    public function edit($id)
    {
        if(!auth() ->check()){
          return redirect('login');
        }

        $trade = Trade::find($id);
        $client = Client::find($trade->client_id);

        return view('/trades/edit_trades',  [
          'id' => $id,
          'trade' => $trade,
          'client' => $client
        ]);
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

        return redirect('/');
    }
}
