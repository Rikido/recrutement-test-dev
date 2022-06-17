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
              <label for="task_charge[{{ $i }}][task_name]">{{ $i + 1 }}:担当項目名</label>
            </th>
            <th>
              <label for="task_charge[{{ $i }}][user]">担当ユーザー</label>
            </th>
            <th>
              <label for="task_charge[{{ $i }}][outline]">作業概要</label>
            </th>
            <th>
              <label for="task_charge[{{ $i }}][order]">実行順序</label>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>
              <input type="text" name="task_charge[{{ $i }}][task_name]" value="{{ old("task_charge.$i.task_name") }}">
            </th>
            <th>
              <select name="task_charge[{{ $i }}][user]" >
                <option value="">選択して下さい</option>
                @foreach($project->group->users as $user)
                <option value="{{ $user->id }}" @if(old("task_charge.$i.user_id") == $user->id) selected @endif>{{ $user->name }}</option>
                @endforeach
              </select>
            </th>
            <th>
              <textarea name="task_charge[{{ $i }}][outline]">{{ old("task_charge.$i.outline") }}</textarea>
            </th>
            <th>
              <input type="number" name="task_charge[{{ $i }}][order]" value="{{ old("task_charge.$i.order") }}">
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

