@extends('layouts.app')

@section('content')
<div class = 'container'>
  <h1>工事実施日程の表示</h1>
  <h3>案件名：{{ $project->project_name }}</h3>
  <strong>案件概要</strong>
  <p>{{ $project->outline }}</p>
  <div>
    <a href="/storage/{{ $project->file_path }}" target="_blank" rel="noopener noreferrer">設計書PDF</a>
  </div>
  <strong>担当グループ:{{ $project->group->group_name }}</strong>

  <h3>担当項目</h3>
  @foreach((array)$task_charges as $task_charge)
    <strong>担当項目名:{{ $task_charge["task_name"] }}</strong>
    <p>担当ユーザー：{{ $task_charge["user_name"] }}</p>
    <p>実行順序:{{ $task_charge["order"] }}</p>
  @endforeach
</div>

@endsection

