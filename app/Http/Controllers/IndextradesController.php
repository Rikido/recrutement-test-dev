<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndextradesController extends Controller
{
    //
    public function index_trades()
    {
        if(!auth() ->check()){
          return redirect('login');
        }
        return view('index_trades');
    }
}
