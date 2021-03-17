<div>
  <a href="{{ url('projects/create') }}">新規案件の登録</a>  
  <h1>登録案件一覧</h1>
  <table>
    <tr>
      <th>案件名</th>
      <th>管理グループ</th>
      <th>案件概要</th>
    </tr>
    @foreach ($projects as $project)
      <tr>
        <td><a href="{{ url('project', $project->id) }}">{{ $project->project_name }}</a></td>
        <td>{{ $project->group->group_name }}</td>
        <td>{{ $project->outline }}<td>
      </tr>
    @endforeach
  </table>
</div>