@extends('layouts.app')

@section('content')
<div class = container>
  <div>
    <div class="d-flex justify-content-end">
      <a href="{{ url('projects/create') }}" class="btn btn-primary">新規案件の登録</a>
    </div>
    <h2>案件一覧</h2>
    <table class="table">
      <thead>
        <tr>
          <th>案件名</th>
          <th>案件概要</th>
          <th>担当グループ</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($projects as $project)
        @foreach ($auths->groups as $auth_group)
          @if($auth_group->id === $project->group->id)
            <tr>
              <th><a href="{{ url('projects', $project->id) }}">{{ $project->project_name }}</a></th>
              <td>{{ $project->outline }}</td>
              <td>{{ $project->group->group_name }}</td>
            </tr>
          @endif
        @endforeach
      @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection