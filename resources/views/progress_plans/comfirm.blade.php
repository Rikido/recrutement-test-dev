<h1>作成進行プラン内容確認画面</h1>

<h2>案件名：{{ $project->project_name }}</h2>
<p>案件概要：{{ $project->outline }}</p>
<div>
	<a href="/storage/{{ $file_name }}" target="_blank" rel="noopener noreferrer">設計書ファイル：{{ $file_name }}</a>
</div>
<h3>担当グループ:{{ $project->group->group_name }}</h3>

<h2>担当項目</h2>
@foreach((array)$task_charges as $task_charge)
	<h3>担当項目名：{{ $task_charge["task_name"] }}</h3>
	<p>担当ユーザー：{{ $task_charge["user_name"] }}</p>
	<p>実行順序：{{ $task_charge["order"] }}</p>
@endforeach

<h2>資材積込み拠点</h2>
@if(!empty($project_resources))
	@foreach($project_resources as $project_resource)
		<h3>拠点名：{{ $project_resource["location_name"] }}</h3>
    	<p>資材名：{{ $project_resource["resource_name"] }}</p>
    	<p>積み込み数：{{ $project_resource["consumption_quantity"] }}個</p>
	@endforeach
@endif

<h2>使用車両一覧</h2>
@if(!empty($select_vehicles))
	@foreach($select_vehicles as $select_vehicle)
		<h3>車両ID：{{ $select_vehicle["vehicle_id"] }}</h3>
		<p>車両最大積載量：{{ $select_vehicle["vehicle_weight"] }}kg</p>
		<p>車両積載サイズ上限：{{ $select_vehicle["vehicle_size"] }}m</p>
    	<p>資材名：{{ $select_vehicle["resource_name"] }}</p>
    	<p>積み込み数：{{ $select_vehicle["resource_count"] }}個</p>
	@endforeach
@endif

<h3>最短工事実施日程：{{ $implementation_date }}</h3>

<form method="post" action="/project/{{ $project->id }}/progress_plan/comfirm">
	@csrf
	<input name="back" type="button" onClick="history.back()" value="修正する" />
	<input type="submit" value="登録する">
</form>
