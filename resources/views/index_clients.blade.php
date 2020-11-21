<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>取引先一覧画面</title>
</head>
<body>

  @include('shared.shared_header')

  <h1>取引先一覧画面</h1>
  @extends('layouts.app')
  @section('content')
  <div class="container">
    <div class="mt-2 row">
      <table class="table table-striped">
        <thead>
          <tr class="table-info">
            <th scope="col">ID</th>
            <th scope="col">取引先名</th>
            <th scope="col">当日時点与信枠</th>
            <th scope="col">未回収掛売り残高</th>
            <th scope="col">貸付可能枠残高</th>
            <th scope="col">登録日時</th>
            <th scope="col">更新日時</th>

            </tr>
        </thead>
        <tbody>

          @foreach($clients as $client)
            <tr>
              <td>{{ $client->id }}</td>
              <td>{{ $client->client_name }}</td>
              <td>-</td>
              <td>-</td>
              <td>-</td>
              <td>{{ $client->created_at }}</td>
              <td>{{ $client->updated_at }}</td>
            </tr>
          @endforeach

          {{ $clients->links() }}
        
        </tbody>
      </table>
    </div>
  </div>
  @endsection

</body>
</html>