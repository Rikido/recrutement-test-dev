@extends('layouts.app')

@section('content')
<div class =container>
  <div>
    <h1>グループ一覧画面</h1>
  </div>
  <div>
    @foreach ($groups as $group)
      <h3>
        {{ $group->id }}.グループ名：{{ $group->group_name }}
      </h3>
      @foreach ($group->users as $user)
        <p>所属ユーザー名：{{ $user->name }}</p>
      @endforeach
    @endforeach
  </div>
</div>
@endsection
