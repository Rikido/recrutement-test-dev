<div>
  <h1>工事案件登録情報</h1>
  @if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif

  <form action="/projects/create" method="POST" enctype="multipart/form-data">
    @csrf

    <label for="name">工事案件名</label></br>
    <input name="project_name" value="{{ old('project_name') }}"></br>

    <label for="group">管理担当グループ</label>
    <select name="group"></br>

      @foreach($auth_user_groups as $user_group)
        <option value="{{ $user_group->id }}" @if(old("group") == $user_group->id) selected @endif>{{ $user_group->group_name }}</option>
      @endforeach

    </select>

    <label for="outline">案件概要</label></br>
    <textarea name="outline" rows="10" cols="60">{{ old('outline') }}</textarea></br>

    <label for="file_path">工事案件のPDFファイルを選択</label></br>
    <input type="file" name="file_path"></br>

    <input type="submit" value="確認画面へ">
  </form>
</div>