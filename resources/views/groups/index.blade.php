@extends('layouts.app')

@section('content')
<div class =container>
  <div class="d-flex justify-content-end">
    <a href="{{ url('projects/create') }}" class="btn btn-primary mr-3">新規案件の登録</a>
    <a href="{{ url('projects/') }}" class="btn btn-primary">案件一覧</a>
  </div>
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
