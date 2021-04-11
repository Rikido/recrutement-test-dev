<h1>工事実施日程の表示画面</h1>
<p>
	車両・技能スタッフの稼働状況により、最短で実行可能な日程を判断し、表示する。（表示のみ）
</p>

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
