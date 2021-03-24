<div>
  <h1>案件名:{{ $project->project_name }}</h1>
  <h2>案件概要:{{ $project->outline }}</h2>
  <a href="/storage/{{ $project->file_path }}" target="_blank" rel="noopener noreferrer">{{ $project->project_name }}設計書PDF</a>
  <p>担当グループ:{{ $project->group->group_name }}</p>

  <a href="/project/{{ $project->id }}/progress_plan/resource_select">進行計画の登録</a>
</div>