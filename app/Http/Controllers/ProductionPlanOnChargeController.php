<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Charge;
use App\Models\ChargeCanWork;
use App\Models\ProductItem;
use App\Models\ProductionPlanOnCharge;
use App\Http\Requests\ProductionPlanOnChargeRequest;
use Carbon\Carbon;

class ProductionPlanOnChargeController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        if(!empty($keyword))
        {
          $test = ProductionPlanOnCharge::where('start_date_of_week',$request->keyword);
          return redirect (route('production_plan_on_charge.past_plan_act', [ 'keyword' => $request->keyword ]));

        }
        $product_items = ProductItem::paginate(5);

        $mon1 = date('Y-m-d',strtotime('last monday' ));
        $mon2 = date('Y-m-d',strtotime('next monday'));
        $mon3 = date('Y-m-d',strtotime('next monday + 1week'));
        $mon4 = date('Y-m-d',strtotime('next monday + 2week'));

        $mondays = [$mon1,$mon2,$mon3,$mon4];

        return view('production_plan_on_charge.index',['product_items' => $product_items, "mondays" => $mondays, "keyword" => $keyword ]);
    }

    public function create($id)
    {
        // 対象アイテムを取得
        $product_item = ProductItem::find($id);
        $itemPlanCharges = $product_item->charges_can_work()->paginate(5);

        // 対象アイテムの生産可能担当者を取得
        $workCanCharges = ChargeCanWork::where('product_item_id',$id)->get('charge_id');
        $charges =[];
        foreach($workCanCharges as $charge)
            {
                $charge = Charge::find($charge->charge_id);
                array_push($charges,$charge);
            }

        $mon1 = date('Y-m-d',strtotime('last monday'));
        $mon2 = date('Y-m-d' ,strtotime('next monday' ));
        $mon3 = date('Y-m-d',strtotime('next monday + 1week'));
        $mon4 = date('Y-m-d',strtotime('next monday + 2week'));

        $mondays = [$mon1,$mon2,$mon3,$mon4];
        return view('production_plan_on_charge.create', ['product_item' => $product_item, 'charges' => $charges, 'mondays' => $mondays, 'itemPlanCharges' => $itemPlanCharges]);
    }

    public function store(ProductionPlanOnChargeRequest $request)
    {

        // 選択週、選択担当者、選択アイテムに予定がすでに存在していないか
        $alredyPlan = ProductionPlanOnCharge::where('start_date_of_week',$request->start_date_of_week)->where('charge_id',$request->charge_id)->where('product_item_id', $request->product_item_id)->exists();

        if($alredyPlan){
            // 予定がすでに存在している場合の処理
            \Session::flash('error_message', '予定は既に登録されています');
            return redirect (route('production_plan_on_charge.create', [ 'product_item_id' => $request->product_item_id ]));
        } else {
            // 予定を新規登録する場合の処理
            $input = $request->all();
            ProductionPlanOnCharge::create($input);
            \Session::flash('flash_message', '予定を追加しました');
            return redirect (route('production_plan_on_charge.create', [ 'product_item_id' => $request->product_item_id ]));
        }
    }

    public function edit($product_item, $charge,$week)
    {
        $product_item = ProductItem::find($product_item);
        $charge = Charge::find($charge);

        // 選択週、選択担当者、選択アイテムに予定がすでに存在していないか
        $alredyPlan = ProductionPlanOnCharge::where('charge_id',$charge->id)->where('product_item_id',$product_item->id)->where('start_date_of_week',$week)->get();

        // 既に予定が存在している場合、編集ページへ
        if(isset($alredyPlan[0])){
            return view('production_plan_on_charge.edit',[ 'alredyPlan' => $alredyPlan, 'product_item' => $product_item, 'charge' => $charge, 'week' => $week]);
        // 予定が存在しない場合、予定作成ページへ
        }else{
            \Session::flash('flash_message', '予定を新規追加してください');
            return redirect (route('production_plan_on_charge.create',[ 'product_item_id' => $product_item]));
        }
    }

    public function update(ProductionPlanOnChargeRequest $request, $id)
    {
        $input = $request->all();
        $ProductionPlanOnCharge = ProductionPlanOnCharge::find($id);
        $ProductionPlanOnCharge->update($input);
        \Session::flash('flash_message', '予定を更新しました');
        return redirect (route('production_plan_on_charge.index'));
    }

    public function past_plan_act(Request $request)
    {
        $keyword = $request->input('keyword');
        $product_items = ProductItem::paginate(5);
        $mon = $request->keyword;
        return view('production_plan_on_charge.past_plan_act',['product_items' => $product_items, 'mon' => $mon, 'keyword' => $keyword]);
    }
}
