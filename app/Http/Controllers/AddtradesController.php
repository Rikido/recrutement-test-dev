<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddtradesController extends Controller
{
    //
    public function add_trades()
    {
        if(!auth() ->check()){
          return redirect('login');
        }
        return view('add_trades');
    }
}
