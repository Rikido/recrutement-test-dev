<h1>利用資材入力画面</h1>

<input type="button" onClick="location.href='/'" value="案件一覧へ戻る" />

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

<form method="post" action="/project/{{ $project->id }}/progress_plan/resource">
	@csrf

	{{-- 1案件で登録できる利用資材は10項目までなので、フォームを10件分表示する --}}
	@for($i = 0; $i < 10; $i++)
		<label for="project_resources[{{ $i }}][resource_name]">{{ $i + 1 }}_資材選択</label>
		<div>
			<select name="project_resources[{{ $i }}][resource_name]" >
				<option value="">選択してください</option>
				@foreach($resources as $resource)
					<option value="{{ $resource->id }}" @if(old("project_resources.$i.resource_name") == $resource->id) selected @endif>
						{{ $resource->resource_name }}
					</option>
				@endforeach
			</select>
		</div>
		<label for="project_resources[{{ $i }}][consumption_quantity]">{{ $i + 1 }}_使用数</label>
		<div>
			<input type="number" min="1" name="project_resources[{{ $i }}][consumption_quantity]" value="{{ old("project_resources.$i.consumption_quantity") }}">
		</div>
	@endfor

	<input type="submit" value="担当割当へ">
</form>
