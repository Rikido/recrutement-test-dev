<h1>案件一覧画面</h1>
<p>登録された工事案件を一覧表示する画面。案件新規作成の起点となる画面</p>

<input type="button" onclick="location.href='/group'" value="グループ一覧">
<input type="button" onclick="location.href='/project/create'" value="案件を作成する">

<div>
	@foreach ($projects as $project)
		<h3>
			<a href="{{ url('/project/'.$project->id) }}">
				{{ $project->id }}_案件名：{{ $project->project_name }}
			</a>
		</h3>
		<p>
			案件概要：{{ $project->outline }}
		</p>
		<p>
			担当グループ：{{ $project->group->group_name }}
		</p>
		<p>
			実施日程：
		</p>
	@endforeach
</div>

