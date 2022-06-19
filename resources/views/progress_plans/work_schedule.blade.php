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
    <p>担当項目名:{{ $task_charge["task_name"] }}</p>
    <p>担当ユーザー：{{ $task_charge["user_name"] }}</p>
    <p>実行順序:{{ $task_charge["order"] }}</p>
  @endforeach
  @if(!empty($project_resources))
    <h3>資材積込み拠点</h3>
    @foreach($project_resources as $project_resource)
      <p>拠点名:{{ $project_resource["location_name"] }}</p>
      <p>資材名:{{ $project_resource["resource_name"] }}</p>
      <p>積込み数:{{ $project_resource["consumption_quantity"] }}</p>
    @endforeach
  @endif

  <form method="post" action="/project/{{ $project->id }}/progress_plan/work_schedule">
  @csrf
  <strong>工事実施日程：{{ $work_date }}</strong>
  <div>
    <button name="back" type="button" onClick="history.back()" class="btn btn-secondary">修正</button>
    <button type="submit" class="btn btn-primary ml-3">次へ</button>
  </div>
  </form>
</div>

@endsection

