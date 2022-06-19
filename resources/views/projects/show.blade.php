@extends('layouts.app')

@section('content')
<div class = 'container'>
<h3 class="text-center">進行プラン詳細</h3>
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
    @if(!empty(current((array)$project->task_charges)))
    <h3>担当項目一覧</h3>
      <table class="table mt-3">
        <thead>
          <tr>
            <th>担当項目名</th>
            <th>担当ユーザー</th>
            <th>作業概要</th>
            <th>実行順序</th>
          </tr>
        </thead>
        @foreach(current((array)$project->task_charges) as $task_charge)
        <tbody>
          <tr>
            <th>
              <a href="/project/{{ $project->id }}/task_charge/{{ $task_charge->id }}/create">{{ $task_charge->task_name }}</a>
            </th>
            <th>{{ $task_charge->user->name }}</th>
            <th>{{ $task_charge->outline }}</th>
            <th>{{ $task_charge->order}}</th>
          </tr>
        </tbody>
        @endforeach
      </table>

      @if(!empty(current((array)$project->project_resources)))
        <h3>資材積込み拠点</h3>
        <table class="table mt-3">
          <thead>
            <tr>
              <th>拠点名</th>
              <th>資材名</th>
              <th>積込み数</th>
            </tr>
          </thead>
          @foreach(current((array)$project->project_resources) as $project_resource)
            @if(isset($project_resource->location))
            <tbody>
              <tr>
                <th>{{ $project_resource->location->location_name }}</th>
                <th>{{ $project_resource->resource->resource_name }}</th>
                <th>{{ $project_resource->consumption_quantity }}</th>
              </tr>
            </tbody>
            @endif
          @endforeach
          </table>
          <div class="d-flex justify-content-end">
            <a href="{{ url('projects/') }}" class="btn btn-secondary mt-1">案件一覧へ</a>
          </div>
      @endif
    @else
    <div>
      <a href="/project/{{ $project->id }}/progress_plan/resource" class="btn btn-secondary">進行計画登録画面</a>
    </div>
    @endif
  </div>
</div>
@endsection
