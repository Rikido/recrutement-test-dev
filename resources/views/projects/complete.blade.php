@extends('layouts.app')

@section('content')
<div class = container>
  <div class ="text-center">
    <h2>案件作成完了画面</h2>
    <h3>登録が完了しました</h3>
    <a href="{{ url('projects') }}">案件一覧へ戻る</a>
  </div>
</div>
@endsection
