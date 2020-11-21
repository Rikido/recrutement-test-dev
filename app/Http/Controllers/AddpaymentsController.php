<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddpaymentsController extends Controller
{
    //
    public function add_payments()
    {
        if(!auth() ->check()){
          return redirect('login');
        }
        return view('add_payments');
    }
}
