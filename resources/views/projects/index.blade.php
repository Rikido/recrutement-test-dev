<h1>案件一覧画面</h1>
<p>登録された工事案件を一覧表示する画面。案件新規作成の起点となる画面</p>

<input type="button" onclick="location.href='/group'" value="グループ一覧">
<input type="button" onclick="location.href='/project/create'" value="案件を作成する">
<input type="button" onclick="location.href='/home'" value="ホーム画面へ">

<div>
	@foreach ($projects as $project)
		<h3>
			{{-- ログインユーザーの所属するgroupを取り出す --}}
			<a @foreach ($auths->groups as $auth_group)
				{{-- ログインユーザーの所属するgroupとprojectのgroupが一致したらリンクを取得 --}}
				@if($auth_group->id === $project->group->id)
					href="{{ url('/project/'.$project->id) }}"
				@endif
			@endforeach>
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

