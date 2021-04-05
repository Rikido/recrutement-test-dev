<h1>グループ一覧画面</h1>
<p>
	登録されたグループを一覧表示する画面<br>
	また、一覧にグループに所属するユーザー名を合わせて表示
</p>
<div>
	@foreach ($groups as $group)
		<h4>
			{{$group->id}}_グループ名：{{$group->group_name}}
		</h4>
		@foreach ($group->users as $user)
			<p>{{$user->id}}_所属ユーザー名：{{$user->name}}</p>
		@endforeach
	@endforeach
</div>
