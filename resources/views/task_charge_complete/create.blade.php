<div>
  <h1>案件名</h1>
  <h1>{{ $project->project_name }}</h1>
  <h2>案件概要</h2>
  <h2>{{ $project->outline }}</h2>
  <a href="/storage/{{ $project->file_path }}" target="_blank" rel="noopener noreferrer">{{ $project->project_name }}設計書PDF</a>

  <form action="/project/{{ $project->id }}/task_charge/{{ $task_charge->id }}/create" method="post">
    @csrf
    <h2>担当項目名</h2>
    <h2>{{ $task_charge->task_name }}</h2>
    <h3>作業概要</h3>
    <p>{{ $task_charge->outline }}</p>
    <textarea name="report" rows="10" cols="60"></textarea>
    <input type="submit" value="提出">
  </form>
</div>