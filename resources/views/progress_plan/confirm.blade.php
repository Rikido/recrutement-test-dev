<div>
  <h1>案件登録情報の確認</h1>
  <h1>案件名:{{ $project->project_name }}</h1>
  <h2>案件概要</h2>
  <p>{{ $project->outline }}</p>
  <a href="/storage/{{ $project->file_path }}" target="_blank" rel="noopener noreferrer">{{ $project->project_name }}設計書PDF</a>
  <h2>担当グループ:{{ $project->group->group_name }}</h2>
  <h2>担当項目</h2>
  @foreach($task_charges as $task_charge)
    <h3>担当項目名:{{ $task_charge["task_name"] }}</h3>
    <h4>担当ユーザー:{{ $task_charge["user"] }}</h4>
    <h4>実行順序:{{ $task_charge["order"] }}
  @endforeach
  <h2>資材積込み拠点</h2>
  <h3>拠点名:{{ $project_resource_stocks["location"]->location_name}}</h3>
  <h3>資材名:{{ $project_resource_stocks["resource"]->resource_name }}</h3>
  <h3>積み込み数:{{ $consumption_quantity }}</h3>

  <h2>工事実施可能日程</h2>
  <h2>{{ $work_date }}</h2>

  <form action="/project/{{ $project->id }}/progress_plan/store" method="post">
  @csrf
    <a href="javascript:history.back();">戻る</a>
    <input type="submit" value="登録">
  </form>

</div>