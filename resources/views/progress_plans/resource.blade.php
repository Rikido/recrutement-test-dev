<h1>利用資材入力画面</h1>
<p>
	案件概要の表示と設計書データをダウンロードできるようにし、進行プランの判断ができるようにする。<br>
	設計書データを確認して、必要資材とその数を入力する。<br>
	・設計書PDFデータのダウンロードは、グループに所属するユーザーのみ可能
	・１案件で登録する利用資材は最大10項目までとする。
</p>
<input type="button" onClick="location.href='/'" value="案件一覧へ戻る" />
<input type="button" onClick="location.href='/project/{{ $project->id }}'" value="案件詳細へ戻る" />

<h3>案件名：{{ $project->project_name }}</h3>

<div>
	<a href="/storage/{{ $file_name }}" target="_blank" rel="noopener noreferrer">設計書ファイル：{{ $file_name }}</a>
</div>

<input type="button" onClick="location.href='/project/{{ $project->id }}/progress_plan/download'" value="設計書ファイルをダウンロードする" />
