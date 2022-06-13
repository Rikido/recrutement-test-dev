@extends('layouts.app')

@section('content')
<div class = container>
  <div>
    <h1>案件作成完了画面</h1>
    <h2>登録が完了しました</h2>
    <a href="{{ url('projects') }}">案件一覧へ戻る</a>
  </div>
</div>
@endsection
