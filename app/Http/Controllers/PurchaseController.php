<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Purchase;
use App\Models\Item;

//バリデーション設定ファイルの読み込み
use App\Http\Requests\StorePurchaseForm;

use Illuminate\support\Facades\DB;

class PurchaseController extends Controller
{
    public function index() {

        $purchases = Purchase::paginate(10);
        // dd($purchases);
        return view('purchases.index', compact('purchases'));
    }

    public function create($id) {
        $item = Item::find($id);
        return view('purchases.create', compact('item'));
    }

    public function store(StorePurchaseForm $request) {

        $purchase = new Purchase;

        $purchase->num = $request->input('num');
        $purchase->item_id = $request->input('item_id');
        $purchase->save();

        return back()->with('message', '発注登録しました。');
    }
}
