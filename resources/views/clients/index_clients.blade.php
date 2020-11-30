<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>取引先一覧</title>
</head>
<body>

  @include('shared.shared_header')

  <h1>取引先一覧</h1>
  @extends('layouts.app')
  @section('content')
  <div class="container">
    <div class="mt-2 row">
      <table class="table table-striped">
        <thead>
          <tr class="table-info">

            <th scope="col">掛取引登録</th>
            <th scope="col">取引先ID</th>
            <th scope="col">取引先名</th>
            <th scope="col">当日時点与信枠</th>
            <th scope="col">未回収掛売残高</th>
            <th scope="col">貸付可能残高</th>
            <th scope="col">登録日時</th>
            <th scope="col">最終更新</th>
            <th scope="col">編集</th>
            <th scope="col">削除</th>

            </tr>
        </thead>
        <tbody>

          @foreach($clients as $client)
            <tr>
              <td><a href="/{{$client->id}}/add_trades">⏩</a></td>
              <td>{{ $client->id }}</td>
              <td>{{ $client->client_name }}</td>
              <td>{{ $client->credit_line }}</td>
              <td>{{ $client->account_receivable_balance }}</td>
              <td>{{ $client->credit_line - $client->account_receivable_balance }}</td>
              <td>{{ $client->created_at }}</td>
              <td>{{ $client->updated_at }}</td>
              <td><a href="{{ route('edit_client', ['id' => $client->id]) }}">🖋</a></td>
              <td><a href="{{ route('confirm_client', ['id' => $client->id]) }}">🗑</a></td>
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