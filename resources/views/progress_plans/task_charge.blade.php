<h1>担当割当画面</h1>
<p>
	担当箇所を作成し、各担当箇所にグループのユーザーから、担当を割り当てる。<br>
	また、各箇所に対する実施順序の設定も行う。<br>
	・一案件で登録する担当項目は最大20件まで<br>
	・案件のグループに所属するユーザーのリストを表示
</p>

<h3>案件名：{{ $project->project_name }}</h3>
<div>
	<a href="/storage/{{ $file_name }}" target="_blank" rel="noopener noreferrer">設計書ファイル：{{ $file_name }}</a>
</div>

<h3>担当項目入力</h3>
<form method="post" action="/project/{{ $project->id }}/progress_plan/task_charge">
	@csrf

	{{-- 1案件で登録できる担当項目は20項目までなので、フォームを20件分表示する --}}
	@for($i = 0; $i < 20; $i++)

		<input type="hidden" name="task_charges[{{ $i }}][project_id]" value="{{ $project->id }}">

		<label for="task_charges[{{ $i }}][task_name]">{{ $i + 1 }}_担当項目名</label>
		<div>
			<input type="text" name="task_charges[{{ $i }}][task_name]" value="{{ old("task_charges.$i.task_name") }}" />
		</div>
		<label for="">{{ $i + 1 }}_担当ユーザー</label>
		<div>
			<select name="task_charges[{{ $i }}][user_id]">
				<option value="">選択してください</option>
				@foreach($project->group->users as $user)
					<option value="{{ $user->id }}" @if(old("task_charges.$i.user_id") == $user->id) selected @endif>
						{{ $user->name }}
					</option>
				@endforeach
			</select>
		</div>
		<label for="task_charges[{{ $i }}][outline]">{{ $i + 1 }}_作業概要</label>
		<div>
			<textarea name="task_charges[{{ $i }}][outline]">{{ old("task_charges.$i.outline") }}</textarea>
		</div>
		<label for="task_charges[{{ $i }}][order]">{{ $i + 1 }}_実行順序</label>
		<div>
			<input type="number" min="1" max="20" name="task_charges[{{ $i }}][order]" value="{{ old("task_charges.$i.order") }}">
		</div>
	@endfor

	<input name="back" type="button" onClick="history.back()" value="修正する" />
	<input type="submit" value="次の画面へ進む">
</form>
