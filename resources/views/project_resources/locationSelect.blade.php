<div>
  <h1>大型資材積み込み拠点</h1>

  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif

  <table>
    <tr>
      <th>貯蔵拠点</th>
      <th>資材名</th>
      <th>在庫</th>
    </tr>
    @foreach ($project_resource_stocks as $project_resource_stock)
      <tr>
        <td>{{ $project_resource_stock->location->location_name }}</td>
        <td>{{ $project_resource_stock->resource->resource_name }}</td>
        <td>{{ $project_resource_stock->stock }}<td>
      </tr>
    @endforeach
  </table>

  <h2>積み込み数選択</h2>

  <form action="/project/{{ $project->id }}/task_charges/project_resources/locationSelect" method="post">
    @csrf
      <p>拠点名:{{ $project_resource_stocks[0]->location->location_name }}</p>
      <p>資材名:{{ $project_resource_stocks[0]->resource->resource_name }}</p>
      <p>在庫数:{{ $project_resource_stocks[0]->stock }}</p>
      <label name="consumption_quantity" >積み込み数</label>
      <input name="consumption_quantity" value="{{ isset($system_suggest_load) ? $system_suggest_load : old('consumption_quantity')}}"></br>
    
      <input type="submit" name="back" value="戻る">
      <input type="submit" value="進行計画登録画面へ">
  </form>
<div>