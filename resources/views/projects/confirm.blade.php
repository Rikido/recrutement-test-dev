@extends('layouts.app')

@section('content')
<div class = 'container'>
  <div>
    <h1>案件情報登録画面</h1>
    <form action="/projects/confirm" method="POST">
      @csrf
      <label for="name">工事案件名</label>
      <div>{{ $input["project_name"] }}</div>

      <label for="outline">案件概要</label>
      <div>{{ $input["outline"] }}</div>


    </form>
  </div>
</div>

@endsection