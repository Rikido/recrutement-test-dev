@extends('layouts.app')

@section('content')
<div class = 'container'>
  <div>
    <h2>案件情報登録画面</h2>
    <div class="d-flex justify-content-end">
      <a href="{{ url('projects/') }}" class="btn btn-primary">案件一覧</a>
    </div>
    {{--バリデーション--}}
    @if ($errors->any())
      <div style="color:red;">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>

  <div>
    <form action="/projects/create" method="POST" enctype="multipart/form-data">
    @csrf
      <div class="form-group">
        <label for="name">案件名</label>
        <input type="text" name="project_name" value="{{ old('project_name') }}" class="form-control">
      </div>
      <div class="form-group">
        <label for="outline">案件概要</label>
        <textarea rows="6" cols="100" name="outline" class="form-control">{{old('outline')}}</textarea>
      </div>
      <div class="form-group">
        <label for="file_path">設計ファイル</label>
        <input type="file" name="file_path" accept=".pdf">
      </div>
      <div class="form-group">
        <label for="group">担当グループ</label>
        <select name="group_id" class="form-control">
          @foreach($auth_user_groups as $auth_user_group)
          <option value="{{$auth_user_group->id}}">{{$auth_user_group->group_name}}</option>
          @endforeach
        </select>
      </div>
      <button type="submit" class="btn btn-primary">作成確認画面へ</button>
    </form>
  </div>
</div>
@endsection
