<h1>案件一覧画面</h1>

<input type="button" onclick="location.href='/group'" value="グループ一覧">
<input type="button" onclick="location.href='/project/create'" value="案件を作成する">
<input type="button" onclick="location.href='/home'" value="ホーム画面へ">

<div>
	@foreach ($projects as $project)
		<h3>
			<a @foreach ($auths->groups as $auth_group)
				{{-- ログインユーザーの所属するgroupとprojectのgroupが一致したら詳細画面のリンクを取得 --}}
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
			{{-- 案件の稼働日が登録されていれば一件表示する（全て同じのため） --}}
			@if(!empty(current($project->user_work_schedules)))
				{{ current($project->user_work_schedules)[0]["work_date"] }}
			@else
				未定
			@endif
		</p>
		@foreach ($auths->groups as $auth_group)
			{{-- ログインユーザーの所属するgroupとprojectのgroupが一致したら進行プランを作成可能 --}}
			@if($auth_group->id === $project->group->id)
				{{-- 担当情報を登録済みの場合は進行プランを作成できない --}}
				@if(empty(current((array)$project->task_charges)))
					<input type="button" onClick="location.href='/project/{{ $project->id }}/progress_plan/resource'" value="進行プランを登録する" />
				@endif
			@endif
		@endforeach
	@endforeach
</div>
