@extends('layouts.app')

@section('content')
<div class = 'container'>
  <div>
    <div class="form-group">
      <label for="name">案件名</label>
      <span class="form-control">{{ $project->project_name }}</span>
    </div>
    <div class="form-group">
      <label for="outline">案件概要</label>
      <textarea rows="6" cols="100" name="outline" class="form-control">{{ $project->outline }}</textarea>
    </div>
    <div class="form-group">
      <label for="file_path">設計書PDF</label>
      <span class="form-control">
      <a href="/storage/{{ $project->file_path }}" target="_blank" rel="noopener noreferrer">{{ $project->project_name }}</a>
      </span>
    </div>
    <div class="form-group">
      <label for="group_name">担当グループ</label>
      <span class="form-control">{{ $project->group->group_name }}</span>
    </div>
    <div>
      <a href="/project/{{ $project->id }}/progress_plan/resource" class="btn btn-secondary">進行計画登録画面</a>
    </div>

  </div>
 </div>

@endsection
