@extends('layouts.app')

@section('content')
<div class = 'container'>
  <h3 class="text-center">担当割当</h3>

  <div>
    <a href="/storage/{{ $project->file_path }}" target="_blank" rel="noopener noreferrer">
      {{ $project->project_name }}設計書ファイル
    </a>
  </div>

  <h3>担当項目</h3>
  <form method="post" action="/project/{{ $project->id }}/progress_plan/task_charge">
    @csrf
    {{-- 1案件で登録する担当項目は最大20項目まで --}}
    @for($i = 0; $i < 20; $i++)
      <table class="table">
        <thead>
          <tr>
            <th>
              <label for="task_charges[{{ $i }}][task_name]">{{ $i + 1 }}_担当項目名</label>
            </th>
            <th>
              <label for="task_charges[{{ $i }}][user]">担当ユーザー</label>
            </th>
            <th>
              <label for="task_charges[{{ $i }}][outline]">作業概要</label>
            </th>
            <th>
              <label for="task_charges[{{ $i }}][order]">実行順序</label>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>
              <input type="text" name="task_charges[{{ $i }}][task_name]" value="{{ old("task_charges.$i.task_name") }}" />
            </th>
            <th>
              <select name="task_charges[{{ $i }}][user_id]">
                <option value="">選択して下さい</option>
                @foreach($project->group->users as $user)
                <option value="{{ $user->id }}" @if(old("task_charges.$i.user_id") == $user->id) selected @endif>{{ $user->name }}</option>
                @endforeach
              </select>
            </th>
            <th>
              <textarea name="task_charges[{{ $i }}][outline]">{{ old("task_charges.$i.outline") }}</textarea>
            </th>
            <th>
              <input type="number" min="1" max="20" name="task_charges[{{ $i }}][order]" value="{{ old("task_charges.$i.order") }}">
            </th>
          </tr>
        </tbody>
      </table>
    @endfor
    <div class="d-flex justify-content-end">
      <button name="back" type="button" onClick="history.back()" class="btn btn-secondary">修正</button>
      <button type="submit" class="btn btn-primary ml-3">次へ</button>
    </div>
  </form>
</div>

@endsection

