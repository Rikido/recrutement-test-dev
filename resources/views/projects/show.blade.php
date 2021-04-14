<h1>進行プラン詳細画面</h1>

<h3>案件名：{{ $project->project_name }}</h3>
<p>
	案件概要：{{ $project->outline }}
</p>
<div>
	<a href="/storage/{{ $file_name }}" target="_blank" rel="noopener noreferrer">設計書ファイル：{{ $file_name }}</a>
</div>
<p>担当グループ：{{ $project->group->group_name }}</p>

@if(!empty(current((array)$project->task_charges)))
    <h3>担当項目一覧</h3>
    @foreach(current((array)$project->task_charges) as $task_charge)
    	<h4>
    		担当項目名：
    		<a href="/project/{{ $project->id }}/task_charge/{{ $task_charge->id }}/create">
    			{{ $task_charge->task_name }}
    		</a>
    	</h4>
    	<p>担当ユーザー：{{ $task_charge->user->name }}</p>
    	<p>作業概要：{{ $task_charge->outline }}</p>
    	<p>実行順序：{{ $task_charge->order }}</p>
    @endforeach
@endif

@if(!empty(current((array)$project->task_charges)))
	<h3>資材積込み拠点一覧</h3>
	@foreach(current((array)$project->project_resources) as $project_resource)
		<h4>拠点名：{{ $project_resource->location->location_name }}</h4>
		<p>資材名：{{ $project_resource->resource->resource_name }}</p>
		<p>積み込み数：{{ $project_resource->consumption_quantity }}</p>
	@endforeach
@endif

<input type="button" onClick="location.href='/'" value="案件一覧へ戻る" />
