<h1>グループ一覧画面</h1>

<input type="button" onClick="location.href='/'" value="案件一覧へ戻る" />

<div>
	@foreach ($groups as $group)
		<h4>
			{{ $group->id }}_グループ名：{{ $group->group_name }}
		</h4>
		@foreach ($group->users as $user)
			<p>{{ $user->id }}_所属ユーザー名：{{ $user->name }}</p>
		@endforeach
	@endforeach
</div>
