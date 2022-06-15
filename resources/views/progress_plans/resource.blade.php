@extends('layouts.app')

@section('content')
<div class = 'container'>
  <h1>利用資材入力画面</h1>
  <p>案件概要：{{ $project->outline }}</p>

  <div>
    <a href="/storage/{{ $project->file_path }}" target="_blank" rel="noopener noreferrer">
      {{ $project->project_name }}設計書ファイル
    </a>
  </div>

  <form method="post" action="{{ url('progress_plan/task_charges') }}">
    @csrf
    {{-- 1案件で登録する利用資材は最大10項目まで --}}
    @for($i = 0; $i < 10; $i++)
      <label for="project_resources[{{ $i }}][resource_name]">{{ $i + 1 }}.利用資材選択</label>
      <div>
      <select name="project_resources[{{ $i }}][resource_name]">
        <option value="">選択してください</option>
        @foreach($resources as $resource)
          <option value="{{ $resource->id }}" @if(old("project_resources.$i.resource_name") == $resource->id) selected @endif>
            {{ $resource->resource_name }}
          </option>
        @endforeach
      </select>
      </div>
      <div>
        <label for="project_resources[{{ $i }}][consumption_quantity]">{{ $i + 1 }}.使用数</label>
      </div>
      <div>
        <input name="project_resources[{{ $i }}][consumption_quantity]" value="{{ old("project_resources.$i.consumption_quantity") }}">
      </div>
    @endfor
    <button type="submit" class="btn btn-primary mt-3">次へ</button>
  </form>

</div>

@endsection

