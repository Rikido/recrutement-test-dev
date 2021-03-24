<div>
  <h1>案件担当割り当て</h1>
  <a href="/storage/{{ $project->file_path }}" target="_blank" rel="noopener noreferrer">{{ $project->project_name }}設計書PDF</a>

  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif

  <form action="/project/{{ $project->id }}/progress_plan/location_select" method="post">
    @csrf

    @for($i = 0 ; $i < 20; $i ++)
      <label for="task_charge[{{ $i }}][task_name]">{{ $i + 1 }}:担当項目名</label>
      <input name="task_charge[{{ $i }}][task_name]" value="{{ old("task_charge.$i.task_name") }}"></br>

      <label for="task_charge[{{ $i }}][user]">担当ユーザー</label>
      <select name="task_charge[{{ $i }}][user]" >
          <option value="">-</option>
        @foreach($project->group->users as $user)
            <option value="{{ $user->id }}" @if(old("task_charge.$i.user_id") == $user->id) selected @endif>{{ $user->name }}</option>
        @endforeach
      </select></br>

      <label for="task_charge[{{ $i }}][outline]">作業概要</label>
      <textarea name="task_charge[{{ $i }}][outline]">{{ old("task_charge.$i.outline") }}</textarea></br>

      <label for="task_charge[{{ $i }}][order]">実行順序</label>
      <input name="task_charge[{{ $i }}][order]" value="{{ old("task_charge.$i.order") }}"></br></br>
    @endfor
      <input type="hidden" name="project_id" value="{{ $project->id }}">

      <a href="javascript:history.back();">戻る</a>
      <input type="submit" value="次の画面へ">
  </form>
</div>