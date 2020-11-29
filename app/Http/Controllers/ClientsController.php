<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Trade;
use App\Models\Repayment;

class ClientsController extends Controller
{
    //
    public function index_clients()
    {
        if(!auth() ->check()){
          return redirect('login');
        }

        $clients = \DB::table('clients')->paginate(5);
        $account_receivable_balance = 0;

        return view('/clients/index_clients', [
          'clients' => $clients,
          'account_receivable_balance' => $account_receivable_balance,
        ]);
    }

    public function add_clients()
    {
        if(!auth() ->check()){
          return redirect('login');
        }
        return view('/clients/add_clients');
    }

    public function register(Request $request)
    {
        $request->validate([
            'client_name' => 'required||unique:clients,client_name',
            'capital_amount' => 'required||digits_between:1,10',
            'annual_sales_1' => 'digits_between:1,13',
            'annual_sales_2' => 'digits_between:1,13',
            'annual_sales_3' => 'digits_between:1,13',
        ]);

        $credit_line = $request->capital_amount*0.1*0.3 + ($request->annual_sales_1*0.5 + $request->annual_sales_2*0.3 + $request->annual_sales_3*0.2)*0.4*0.3 + 0*0.4;
        $account_receivable_balance = 0;
        $request->request->add(['credit_line'=>$credit_line,'account_receivable_balance'=>$account_receivable_balance]);
        Client::create($request->all());
        


        return redirect('/');
    }

    public function edit($id)
    {
        if(!auth() ->check()){
          return redirect('login');
        }
        return view('/clients/edit_clients',  [
          'id' => $id,
          'client' => Client::find($id)
        ]);
    }

    public function update($id, Request $request, Client $client)
    {
      $request->validate([
          'client_name' => 'required',
          'capital_amount' => 'required||digits_between:1,10',
          'annual_sales_1' => 'digits_between:1,13',
          'annual_sales_2' => 'digits_between:1,13',
          'annual_sales_3' => 'digits_between:1,13',
      ]);

        if(!auth() ->check()){
          return redirect('login');
        }

        $client = Client::find($id);
        $client->client_name = $request->client_name;
        $client->capital_amount = $request->capital_amount;
        $client->annual_sales_1 = $request->annual_sales_1;
        $client->annual_sales_2 = $request->annual_sales_2;
        $client->annual_sales_3 = $request->annual_sales_3;
        $client->credit_score = $request->credit_score;
        $client->save();

        return redirect('/');
    }

    public function destroy_confirm($id)
    {
        if(!auth() ->check()){
          return redirect('login');
        }
        return view('/clients/destroy_clients_confirm',  [
          'id' => $id,
          'client' => Client::find($id)
        ]);
    }

    public function destroy($id, Request $request, Client $client)
    {
        if(!auth() ->check()){
          return redirect('login');
        }

        $client = Client::find($id);
        $trades = Trade::where('client_id', $id)
                ->get();

        if(!$trades == ""){
          foreach($trades as $trade){
            $repayments = Repayment::where('trade_id', $trade->id)
                        ->get();
            $repayments->each->delete();
            }
          $trades->each->delete();
        }

        $client->delete();

        return redirect('/');
    }
}
