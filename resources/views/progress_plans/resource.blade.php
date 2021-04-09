<h1>利用資材入力画面</h1>
<p>
	案件概要の表示と設計書データをダウンロードできるようにし、進行プランの判断ができるようにする。<br>
	設計書データを確認して、必要資材とその数を入力する。<br>
	・設計書PDFデータのダウンロードは、グループに所属するユーザーのみ可能<br>
	・１案件で登録する利用資材は最大10項目までとする。
</p>
<input type="button" onClick="location.href='/'" value="案件一覧へ戻る" />
<input type="button" onClick="location.href='/project/{{ $project->id }}'" value="案件詳細へ戻る" />

<h3>案件名：{{ $project->project_name }}</h3>
<p>
	案件概要：{{ $project->outline }}
</p>
<div>
	<a href="/storage/{{ $file_name }}" target="_blank" rel="noopener noreferrer">設計書ファイル：{{ $file_name }}</a>
</div>
@foreach($auths->groups as $auth_group)
	@if($auth_group->id === $project->group->id)
		{{-- 設計書PDFデータのダウンロード --}}
		<input type="button" onClick="location.href='/project/{{ $project->id }}/progress_plan/download'" value="設計書ファイルをダウンロードする" />
	@endif
@endforeach

{{-- 利用資材の入力 --}}
<form method="post" action="/project/{{ $project->id }}/progress_plan/resource">
	@csrf

	{{-- 1案件で登録できる利用資材は10項目までなので、フォームを10件分表示する --}}
	@for($i = 0; $i < 10; $i++)
		{{-- 変数名の最後に[]をつけることでフォームの内容が配列として扱われる --}}
		<label for="project_resources[{{ $i }}][resource_name]">{{ $i + 1 }}_資材選択</label>
		<div>
			{{-- resourcesのresource_nameを選択する --}}
			<select name="project_resources[{{ $i }}][resource_name]" >
				<option value="">選択してください</option>
				@foreach($resources as $resource)
					{{-- selectタグのname属性の値をold()関数の引数に指定 --}}
					<option value="{{ $resource->id }}" @if(old("project_resources.$i.resource_name") == $resource->id) selected @endif>
						{{ $resource->resource_name }}
					</option>
				@endforeach
			</select>
		</div>
		{{-- project_resoucesのconsumption_quantityを選択する --}}
		<label for="project_resources[{{ $i }}][consumption_quantity]">{{ $i + 1 }}_使用数</label>
		<div>
			{{-- inputタグは、name属性の値をold()関数の引数に入れる --}}
			<input type="number" min="1" name="project_resources[{{ $i }}][consumption_quantity]" value="{{ old("project_resources.$i.consumption_quantity") }}">
		</div>
	@endfor

	<input type="submit" value="担当割当へ">
</form>
