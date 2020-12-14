<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Item;
use App\Models\Receipt;
use App\Models\Purchase;
use App\Models\Allocate;

//バリデーション設定ファイルの読み込み
use App\Http\Requests\StoreItemForm;

use Illuminate\support\Facades\DB;

class ItemController extends Controller
{
    public function index() {

        $items = Item::paginate(5);

        
        return view('items.index', compact('items'));
    }

    public function create() {
        return view('items.create');
    }

    public function store(StoreItemForm $request) {
        $item = new Item;

        $item->item_name = $request->input('item_name');

        
        $item->save();
        
        return redirect('/')->with('message', '部材を登録しました。');
    
    }
}