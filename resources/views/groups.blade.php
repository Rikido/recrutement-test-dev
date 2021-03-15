<div>
  <h1>グループと所属ユーザー一覧</h1>
  <div>
    @foreach ($groups as $group)
      <h2>グループ名: {{$group->group_name}}</h2>
      <h3>所属ユーザー</h3>
      @foreach ($group->users as $user)
        <h4>ユーザー名: {{$user->name}}</h4>
      @endforeach
    @endforeach
  </div>
</div>