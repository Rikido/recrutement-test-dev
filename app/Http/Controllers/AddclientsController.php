<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddclientsController extends Controller
{
    //
    public function add_clients()
    {
        if(!auth() ->check()){
          return redirect('login');
        }
        return view('add_clients');
    }

    public function register(Request $request)
    {
        $request->validate([
            'client_name' => 'required',
            'capital_amount' => 'required||digits_between:1,10',
            'annual_sales_1' => 'digits_between:1,13',
            'annual_sales_2' => 'digits_between:1,13',
            'annual_sales_3' => 'digits_between:1,13',
        ]);
        
        
        return;
    }
}