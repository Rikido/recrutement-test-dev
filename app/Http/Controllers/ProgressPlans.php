<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProgressPlans extends Controller
{
    //利用資材入力
    public function resource($id) {
        return view('progress_plans/resource');
    }
}
