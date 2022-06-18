@extends('layouts.app')

@section('content')
<div class = 'container'>
  <h1>大型資材積込み拠点選択</h1>
  <form method="post" action="/project/{{ $project->id }}/progress_plan/location">
  <table class="table">
    <thead class="thead-light">
      <tr>
        <th>拠点名</th>
        <th>資材名</th>
        <th>在庫数</th>
        <th>積込み数</th>
      </tr>
    </thead>
    @foreach ($resource_stocks_index as $key => $resource_stock)
    <tbody>
      <tr>
        <th>
          {{ $resource_stock->location->location_name }}
        </th>
        <th>
          {{ $resource_stock->resource->resource_name  }}
        </th>
        <th>
          {{ $resource_stock->stock }}
        </th>
        <th>

        </th>
      </tr>
    </tbody>
  @endforeach
  </table>
  <div class="d-flex justify-content-end">
      <button name="back" type="button" onClick="history.back()" class="btn btn-secondary">修正</button>
      <button type="submit" class="btn btn-primary ml-3">次へ</button>
    </div>
  </form>
</div>

@endsection

