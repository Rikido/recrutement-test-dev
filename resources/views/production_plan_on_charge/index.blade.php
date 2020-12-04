@extends('layouts.app')
@section('content')

<div class="container">
  <div class="row">
    <h2>実績 / 予定</h2>
    <div class="col-sm-4" style="padding:20px 0; padding-left:0px;">
      <form class="form-inline" action="{{url('/')}}">
        <label for="keyword" class="ml-4" >週検索(週開始日を入力してください)</label><br>
        <input type="text" name="keyword" value="{{ $keyword }}" class="ml-4" placeholder="例)2020-11-30">
        <input type="submit" value="検索" class="btn btn-info">
      </form>
      </div>
  </div>
  <div class="row mt-3">
    <table class="table">
      <thead>
        <tr>
          <th>実績 / 予定</th>
          @foreach($mondays as $mon)
            <th>{{ $mon }}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>
        @foreach($product_items as $product_item)
          <tr>
            <th>{{ $product_item->item_name }}</th>
            <?php
            $inLastMondayAct = 0;
            $inLastMondayPlan = 0;
            $inNextMondayAct = 0;
            $inNextMondayPlan = 0;
            $in2NextMondayAct = 0;
            $in2NextMondayPlan = 0;
            $in3NextMondayAct = 0;
            $in3NextMondayPlan = 0;

            // アイテム別、週別の実績を算出
            for($i=0; $i<$product_item->charges_act->count(); $i ++)
            {
              // production_act_on_chargeテーブルから週別でソートして合計
              if($product_item->charges_act[$i]->pivot->start_date_of_week == $mondays[0])
              {
                $num = $product_item->charges_act[$i]->pivot->num;
                $inLastMondayAct = $inLastMondayAct + $num;
              }
              elseif($product_item->charges_act[$i]->pivot->start_date_of_week == $mondays[1])
              {
                $num = $product_item->charges_act[$i]->pivot->num;
                $inNextMondayAct = $inNextMondayAct + $num;
              }
              elseif($product_item->charges_act[$i]->pivot->start_date_of_week == $mondays[2])
              {
                $num = $product_item->charges_act[$i]->pivot->num;
                $in2NextMondayAct = $in2NextMondayAct + $num;
              }
              elseif($product_item->charges_act[$i]->pivot->start_date_of_week == $mondays[3])
              {
                $num = $product_item->charges_act[$i]->pivot->num;
                $in3NextMondayAct = $in3NextMondayAct + $num;
              }
            }
            
            // アイテム別、週別の予定を算出
            for($i=0; $i<$product_item->charges_plan->count(); $i ++)
            {
              // production_plan_on_chargeテーブルから週別でソートして合計
              if($product_item->charges_plan[$i]->pivot->start_date_of_week == $mondays[0])
              {
                $num = $product_item->charges_plan[$i]->pivot->num;
                $inLastMondayPlan = $inLastMondayPlan + $num;
              }elseif($product_item->charges_plan[$i]->pivot->start_date_of_week == $mondays[1])
              {
                $num = $product_item->charges_plan[$i]->pivot->num;
                $inNextMondayPlan = $inNextMondayPlan + $num;
              }elseif($product_item->charges_plan[$i]->pivot->start_date_of_week == $mondays[2])
              {
                $num = $product_item->charges_plan[$i]->pivot->num;
                $in2NextMondayPlan = $in2NextMondayPlan + $num;
              }elseif($product_item->charges_plan[$i]->pivot->start_date_of_week == $mondays[3])
              {
                $num = $product_item->charges_plan[$i]->pivot->num;
                $in3NextMondayPlan = $in3NextMondayPlan + $num;
              }
            }
            ?>
            <td>{{ $inLastMondayAct }} / {{ $inLastMondayPlan }}</td>
            <td>{{ $inNextMondayAct }} / {{ $inNextMondayPlan }}</td>
            <td>{{ $in2NextMondayAct }} / {{ $in2NextMondayPlan }}</td>
            <td>{{ $in3NextMondayAct }} / {{ $in3NextMondayPlan }}</td>
            <td>
              <a href="{{ route ('production_plan_on_charge.create', $product_item->id) }}" class="btn btn-primary">予定入力</a>
              <a href="{{ route ('production_act_on_charge.create', $product_item->id) }}" class="btn btn-primary">実績入力</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div class="d-flex justify-content-center">
      {{ $product_items->links() }}
    </div>
  </div>
</div>

@endsection