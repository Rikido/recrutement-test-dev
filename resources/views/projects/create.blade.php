<h1>案件登録画面</h1>
<p>
	案件概要と設計書データを登録、<br>
	所有グループの登録をする
</p>

<h3>入力フォーム</h3>
{{-- バリデーションエラーの表示 --}}
@if ($errors->any())
	<div style="color:red;">
    	<ul>
    		@foreach ($errors->all() as $error)
    			<li>{{ $error }}</li>
    		@endforeach
    	</ul>
    </div>
@endif
{{-- ファイルを送信するためform要素にenctype="multipart/form-data"を記述 --}}
<form method="post" action="{{ url('project/create') }}" enctype="multipart/form-data">
	@csrf

	<label>案件名</label>
	<div>
		{{-- バリデーションエラーで画面が戻った際、 old()関数を使用して入力値を表示する --}}
		<input type="text" name="project_name" value="{{ old('project_name') }}" />
	</div>
	<label>案件概要</label>
	<div>
		<textarea name="outline">{{ old('outline') }}</textarea>
	</div>
	<label>設計書pdfファイル登録</label>
	<div>
		<input type="file" accept=".pdf" name="file_path" />
	</div>
	<label>担当グループ選択</label>
	<div>
		<select name="group_id">
			@foreach($auth_user_groups as $auth_user_group)
				{{-- selectのname属性の値をold()の引数に指定 --}}
				{{-- if文でidの値が「１」なら@if(old('id')=='1') selecte @endif がselectedされる --}}
				<option value="{{ $auth_user_group->id }}" @if(old("group_id") == $auth_user_group->id) selected @endif>
					{{ $auth_user_group->group_name }}
				</option>
			@endforeach
		</select>
	</div>

	<input type="submit" value="作成案件確認画面へ" />
</form>

<a href="{{ url('/') }}">案件一覧へ戻る</a>
