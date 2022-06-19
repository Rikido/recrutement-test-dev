@extends('layouts.app')

@section('content')
<div class = 'container'>
  <h1>工事担当箇所実施報告</h1>

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
      <label for="task-name">担当項目名</label>
      <span class="form-control">{{ $task_charge->task_name }}</span>
    </div>
    <div class="form-group">
      <label for="outline">作業概要</label>
      <span class="form-control">{{ $task_charge->outline }}</span>
    </div>
    <form action="/project/{{ $project->id }}/task_charge/{{ $task_charge->id }}/create" method="post">
      @csrf
      <div class="form-group">
        <label for="report">検査結果入力</label>
        <textarea rows="6" cols="100" name="report" class="form-control"></textarea>
      </div>
      <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">提出する</button>
      </div>
    </form>
</div>

@endsection

