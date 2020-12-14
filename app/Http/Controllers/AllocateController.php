<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Allocate;
use App\Models\Item;
use App\Models\Receipt;

//バリデーション設定ファイルの読み込み
use App\Http\Requests\StoreAllocateForm;

use Illuminate\support\Facades\DB;

class AllocateController extends Controller
{
    public function index() {
        $allocates = Allocate::paginate(10);

        return view('allocates.index', compact('allocates'));
    }

    public function create($id) {
        $item = Item::find($id); 

        //割当する部材に紐付いている入庫個数の合計を求める
        $receipts = $item->receipts;
        $i = 0;
        foreach($receipts as $receipt) {
            $i = $i + $receipt->num; 
        };

        //割当済み個数を求める
        $allocates = $item->allocates;
        $number = 0;
        foreach($allocates as $all) {
            $number = $number + $all->num; 
        };
        
        // 未割当個数
        $num = $i - $number;

        return view('allocates.create', compact('item', 'num'));
    }

    public function store(StoreAllocateForm $request) {
        $allocate = new Allocate;

        $allocate->num = $request->input('num');
        $allocate->name = $request->input('name');
        $allocate->item_id = $request->input('item_id');
        
        // 入庫個数　>= 割当個数　

        //割当する部材に紐付いている入庫個数の合計を求める
        $item = Item::find($allocate->item_id);
        $receipts = $item->receipts;
        $i = 0;
        foreach($receipts as $receipt) {
            $i = $i + $receipt->num; 
        };

        //割当済み個数を求める
        $allocates = $item->allocates;
        $number = 0;
        foreach($allocates as $all) {
            $number = $number + $all->num; 
        };
        
        // 未割当個数
        $num = $i - $number;


        if ($allocate->num <= $num) {
            $allocate->save();
            return back()->with('message', '資材を割当てました。');
        }else{
            return back()->with('alert', '割当可能数を確認の上、割当個数を入力してください。');
        }
        
            
    
        
    }
}
