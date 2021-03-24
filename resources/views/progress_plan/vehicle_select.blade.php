<div>

  <table>
    <tr>
      <th>車両ID</th>
      <th>車両最大積載量</th>
      <th>車両サイズ上限</th>
    </tr>
    @foreach ($vehicles as $vehicle)
      <tr>
        <td>{{ $vehicle->id }}</td>
        <td>{{ $vehicle->max_weight }}kg</td>
        <td>{{ $vehicle->max_size }}m<td>
      </tr>
    @endforeach
  </table>

  <form action="/project/{{ $project->id }}/progress_plan/work_schedule" method="post">
    @csrf

    <label name="vehicle">使用する車両のID</label>
    <select name="vehicle" >
        <option value="">-</option>
      @foreach($vehicles as $vehicle)
          <option value="{{ $vehicle->id }}" @if(old("vehicle") == $vehicle->id) selected @endif>{{ $vehicle->id }}</option>
      @endforeach
    </select></br>
    
    <a href="javascript:history.back();">戻る</a>
    <input type="submit" value="次の画面へ">
  </form>
<div>