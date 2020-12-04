@extends('layouts.app')
@section('content')

<div class="container">
  <div class="row">
    <h2>実績 / 予定({{ $keyword }})</h2>
    <div class="col-sm-4" style="padding:20px 0; padding-left:0px;">
      <form class="form-inline" action="{{url('/')}}">
        <div class="form-group">
        <input type="text" name="keyword" value="{{ $keyword }}" class="form-control" placeholder="名前を入力してください">
        </div>
        <input type="submit" value="検索" class="btn btn-info">
      </form>
      </div>
  </div>
  <div class="row mt-3">
    <table class="table">
      <thead>
        <tr>
          <th>実績 / 予定</th>
          <th>{{ $mon }}</th>
        </tr>
      </thead>
      <tbody>
      @foreach($product_items as $product_item)
          <tr>
            <th>{{ $product_item->item_name }}</th>
            <?php
            $MondayAct = 0;
            $MondayPlan = 0;

            // アイテム別の実績を算出
            for($i=0; $i<$product_item->charges_act->count(); $i ++)
            {
              // production_act_on_chargeテーブルから週別でソートして合計
              if($product_item->charges_act[$i]->pivot->start_date_of_week == $mon)
              {
                $num = $product_item->charges_act[$i]->pivot->num;
                $MondayAct = $MondayAct + $num;
              }
            }
            
            // アイテム別の予定を算出
            for($i=0; $i<$product_item->charges_plan->count(); $i ++)
            {
              // production_plan_on_chargeテーブルから週別でソートして合計
              if($product_item->charges_plan[$i]->pivot->start_date_of_week == $mon)
              {
                $num = $product_item->charges_plan[$i]->pivot->num;
                $MondayPlan = $MondayPlan + $num;
              }
            }
            ?>
            <td>{{ $MondayAct }} / {{ $MondayPlan }}</td>
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