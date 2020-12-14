<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Receipt;
use App\Models\Item;
use App\Models\Purchase;

//バリデーション設定ファイルの読み込み
use App\Http\Requests\StoreReceiptForm;

use Illuminate\support\Facades\DB;

class ReceiptController extends Controller
{
    public function index() {
        $receipts = Receipt::paginate(10);

        return view('receipts.index', compact('receipts'));

    }

    public function create($id) {
        $item = Item::find($id); 

        //入庫する部材に紐付いている発注個数の合計を求める
        $purchases = $item->purchases;
        $i = 0;
        foreach($purchases as $purchase) {
            $i = $i + $purchase->num; 
        };

        //入庫済み個数を求める
        $receipts = $item->receipts;
        $number = 0;
        foreach($receipts as $rec) {
            $number = $number + $rec->num; 
        };
        
        // 未入庫個数
        $num = $i - $number;

        return view('receipts.create', compact('item', 'num'));
    }

    public function store(StoreReceiptForm $request) {
        $receipt = new Receipt;

        $receipt->num = $request->input('num');
        $receipt->item_id = $request->input('item_id');
        
        // 発注個数　>= 入庫個数　

        //入庫する部材に紐付いている発注個数の合計を求める
        $item = Item::find($receipt->item_id);
        $purchases = $item->purchases;
        $i = 0;
        foreach($purchases as $purchase) {
            $i = $i + $purchase->num; 
        };

        //入庫済み個数を求める
        $receipts = $item->receipts;
        $number = 0;
        foreach($receipts as $rec) {
            $number = $number + $rec->num; 
        };
        
        // 未入庫個数
        $num = $i - $number;


        if ($receipt->num <= $num) {
            $receipt->save();
            return back()->with('message', '入庫登録しました。');
        }else{
            return back()->with('alert', '入庫可能個数を確認の上、個数を入力してください。');
        }
        
            
    }
}

