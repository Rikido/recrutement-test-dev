@extends('layouts.app')

@section('content')
<div class = 'container'>
  <div>
    <h1>案件情報登録画面</h1>
    <form method="post" action="{{ url('projects/confirm') }}">
      @csrf
      <div class="form-group">
        <label for="name">案件名</label>
        <span class="form-control">{{ $input["project_name"] }} </span>
      </div>
      <div class="form-group">
        <label for="outline">案件概要</label>
        <span class="form-control">{{ $input["outline"] }}</span>
      </div>
      <div class="form-group">
        <label for="file_path">設計ファイル</label>
        <a href="/storage/{{ $path }}" target="_blank" rel="noopener noreferrer">{{ $input["project_name"] }}PDF</a>
      </div>

      <button name="back" type="submit" value="true" class="btn btn-secondary">戻る</button>
      <button type="submit" class="btn btn-primary">登録</button>
    </form>
  </div>
</div>

@endsection

