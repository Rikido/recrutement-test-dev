<h1>大型資材積込み拠点選択画面</h1>
<p>
	大型資材が入力されていた場合、表示。<br>
	システムで判断した、積込み拠点と各数量を表示<br>
	また、全貯蔵拠点の一覧と各在庫を表示し、システムが提案する積込みに対する、任意の積込み計画を設定可能にする。<br>
	・予めシステムで算出した積込み数を入力済み状態で表示する。
</p>

<h3>貯蔵拠点一覧及び各資材の在庫数、大型資材積み込み数選択</h3>
<form method="post" action="/project/{{ $project->id }}/progress_plan/location">
	@csrf

	<?php $i = 0; ?>
	@foreach ($resource_stocks_index as $key => $resource_stock)
		<input type="hidden" name="resource_stocks[{{ $i }}][project_id]" value="{{ $project->id }}">

		<label for="resource_stocks[{{ $i }}][location_id]">拠点名</label>
    	<div>
    		{{ $resource_stock->location->location_name }}
    		<input type="hidden" name="resource_stocks[{{ $i }}][location_id]" value="{{ $resource_stock->location_id }}">
    	</div>
    	<label for="resource_stocks[{{ $i }}][resource_id]">資材名</label>
    	<div>
    		 {{ $resource_stock->resource->resource_name  }}
    		 <input type="hidden" name="resource_stocks[{{ $i }}][resource_id]" value="{{ $resource_stock->resource_id }}">
    	</div>
    	<label>在庫数</label>
    	<div>
    		{{ $resource_stock->stock }}
    	</div>
    	<label for="resource_stocks[{{ $i }}][consumption_quantity]">積み込み数</label>
    	<div>
    		<input type="number" min="1" name="resource_stocks[{{ $i }}][consumption_quantity]" value=
        		@foreach ($location_select_array as $key => $location_select)
        			@if(($location_select["location"] == $resource_stock->location_id) && ($location_select["resource"] == $resource_stock->resource_id))
        				{{ old("consumption_quantity", $location_select["consumption_quantity"]) }}
        			@else
        				{{ old("consumption_quantity") }}
        			@endif
        		@endforeach
    		 >
    	</div>
    	<?php $i++; ?>
	@endforeach

	<input name="back" type="button" onClick="history.back()" value="修正する" />
	<input type="submit" value="次の画面へ進む">
</form>