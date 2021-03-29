<div>
  <h1>案件名:{{ $project->project_name }}</h1>
  <h2>案件概要:{{ $project->outline }}</h2>
  <a href="/storage/{{ $project->file_path }}" target="_blank" rel="noopener noreferrer">{{ $project->project_name }}設計書PDF</a>
  <p>担当グループ:{{ $project->group->group_name }}</p>

  @if ($project->task_charges->count() != 0)
    <table>
      <tr>
        <th>担当項目</th>
        <th>担当ユーザー</th>
        <th>作業概要</th>
        <th>実行順序</th>
      </tr>
      @foreach ($project->task_charges as $task_charge)
        <tr>
          <td><a href="/project/{{ $project->id }}/task_charge/{{ $task_charge->id }}/create">{{ $task_charge->task_name }}</a></td>
          <td>{{ $task_charge->user->name }}</td>
          <td>{{ $task_charge->outline }}<td>
          <td>{{ $task_charge->order }}
        </tr>
      @endforeach
    </table>

    <table>
      <tr>
        <th>拠点名</th>
        <th>資材名</th>
        <th>積み込み数</th>
      </tr>
      @foreach ($project->project_resources as $project_resource)
        @if( isset($project_resource->location))
          <tr>
            <td>{{ $project_resource->location->location_name }}</td>
            <td>{{ $project_resource->resource->resource_name }}<td>
            <td>{{ $project_resource->consumption_quantity }}</td>
          </tr>
        @endif
      @endforeach
    </table>

  @else
    <a href="/project/{{ $project->id }}/progress_plan/resource_select">進行計画の登録</a>
  @endif
</div>