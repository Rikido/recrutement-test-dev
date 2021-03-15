<div>
  <h1>工事案件情報の確認</h1>
  <form action="/projects/confirm" method="POST">
    @csrf

    <label for="name">工事案件名</label>
    <div>{{ $input["project_name"] }}</div>

    <label for="outline">案件概要</label>
    <div>{{ $input["outline"] }}</div>

    <label for="file_path">工事案件PDF</label>
    <a href="/storage/{{ $path }}" target="_blank" rel="noopener noreferrer">{{ $input["project_name"] }}PDF</a>

    <input name="back" type="submit" value="登録情報の修正" />
    <input type="submit" value="登録" />
  </form>
</div>
