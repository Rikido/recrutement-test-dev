<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>掛取引一覧</title>
</head>
<body>

  @include('shared.shared_header')

  <h1>掛取引一覧</h1>

    @extends('layouts.app')
    @section('content')
    <div class="container">
      <div class="mt-2 row">
        <table class="table table-striped">
          <thead>
            <tr class="table-info">
              <th scope="col">月次返済処理</th>
              <th scope="col">掛取引ID</th>
              <th scope="col">対象取引先</th>
              <th scope="col">掛取引額</th>
              <th scope="col">未回収掛売り残高</th>
              <th scope="col">支払い遅延</th>
              <th scope="col">掛取引登録日時</th>
              <th scope="col">最終更新日時</th>
              <th scope="col">削除</th>
    
              </tr>
          </thead>
          <tbody>

            @foreach($trades as $trade)
              <tr>
                <td><a href="/{{$trade->id}}/add_repayments">⏩</a></td>
                <td>{{ $trade->id }}</td>
                <td>{{ $trade->clients->client_name ??''}}</td>
                <td>{{ $trade->transaction_amount }}</td>
                <td>{{ $trade->transaction_balance }}</td>

                @if ($trade->repayments->isEmpty())
                <td>-</td>
                @elseif ($trade->repayments->where('delay_flag',"yes")->isEmpty())
                <td>なし</td>
                @else
                <td>あり</td>
                @endif

                <td>{{ $trade->created_at }}</td>
                <td>{{ $trade->updated_at }}</td>
                <td><a href="{{ route('confirm_trade', ['id' => $trade->id]) }}">🗑</a></td>
              </tr>
          @endforeach
          
          </tbody>
        </table>
      </div>
    </div>
    @endsection
    
      
</body>
</html>