<h1>作成案件確認画面</h1>
<h3>案件を確認する</h3>
<form method="post" action="{{ url('project/comfirm') }}">
	@csrf
	<label>案件名</label>
	<div>
		{{ $input['project_name'] }}
	</div>
	<label>案件概要</label>
	<div>
		{{ $input['outline'] }}
	</div>
	<label>設計書pdfファイル</label>
	<div>
		<a href="/storage/{{ $file_name }}" target="_blank" rel="noopener noreferrer">{{ $file_name }}</a>
	</div>

	<input name="back" type="button" onClick="history.back()" value="修正する" />
	<input type="submit" value="登録する" />

</form>
