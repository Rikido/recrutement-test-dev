@extends('layouts.app')

@section('content')
<div class = 'container'>
  <h3 class="text-center">利用資材入力画面</h3>
  <p>案件概要：{{ $project->outline }}</p>

  <div>
    <a href="/storage/{{ $project->file_path }}" target="_blank" rel="noopener noreferrer">
      {{ $project->project_name }}設計書ファイル
    </a>
  </div>

  <form method="post" action="/project/{{ $project->id }}/progress_plan/resource">
    @csrf
    {{-- 1案件で登録する利用資材は最大10項目まで --}}
    @for($i = 0; $i < 10; $i++)
      <table class="table">
      <thead>
        <tr>
          <th>
            <label for="project_resources[{{ $i }}][resource_name]">{{ $i + 1 }}.利用資材選択</label>
          </th>
          <th>
            <label for="project_resources[{{ $i }}][consumption_quantity]">{{ $i + 1 }}.使用数</label>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>
            <select name="project_resources[{{ $i }}][resource_name]">
              <option value="">選択してください</option>
              @foreach($resources as $resource)
                <option value="{{ $resource->id }}" @if(old("project_resources.$i.resource_name") == $resource->id) selected @endif>
                  {{ $resource->resource_name }}
                </option>
              @endforeach
            </select>
          </th>
          <th>
            <input name="project_resources[{{ $i }}][consumption_quantity]" value="{{ old("project_resources.$i.consumption_quantity") }}">
          </th>
        </tr>
      </tbody>
    </table>
    @endfor
    <div class="d-flex justify-content-end">
      <button type="submit" class="btn btn-primary">次へ</button>
    </div>
  </form>
</div>

@endsection

