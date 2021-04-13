<h1>進行プラン詳細画面</h1>

<input type="button" onClick="location.href='/'" value="案件一覧へ" />

<h3>案件名：{{ $project->project_name }}</h3>
<p>
	案件概要：{{ $project->outline }}
</p>
<div>
	<a href="/storage/{{ $file_name }}" target="_blank" rel="noopener noreferrer">設計書ファイル：{{ $file_name }}</a>
</div>
<p>担当グループ：{{ $project->group->group_name }}</p>

<input type="button" onClick="location.href='/project/{{ $project->id }}/progress_plan/resource'" value="進行プランを登録する" />
