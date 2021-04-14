<h1>工事担当箇所実施報告画面</h1>

<h3>案件名：{{ $project->project_name }}</h3>
<p>
	案件概要：{{ $project->outline }}
</p>
<div>
	<a href="/storage/{{ $file_name }}" target="_blank" rel="noopener noreferrer">設計書ファイル：{{ $file_name }}</a>
</div>

<h4>担当項目名：{{ $task_charge->task_name }}</h4>
<p>
	作業概要：{{ $task_charge->outline }}
</p>
<form action="/project/{{ $project->id }}/task_charge/{{ $task_charge->id }}/create" method="post">
	@csrf

	<label>検査結果入力</label>
	<div>
		<textarea name="report"></textarea>
	</div>

	<input type="submit" value="提出する">
</form>

<input name="back" type="button" onClick="history.back()" value="進行プラン詳細へ戻る" />
<input type="button" onClick="location.href='/'" value="案件一覧へ戻る" />
