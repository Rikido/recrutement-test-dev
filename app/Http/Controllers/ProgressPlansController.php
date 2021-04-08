<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProgressPlansController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    // 利用資材入力画面
    public function resource($id) {
        return view('progress_plans.resource');
    }
}
