<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>月次返済一覧</title>
</head>
<body>

  @include('shared.shared_header')

  <h1>月次返済一覧</h1>

    @extends('layouts.app')
    @section('content')
    <div class="container">
      <div class="mt-2 row">
        <table class="table table-striped">
          <thead>
            <tr class="table-info">
              <th scope="col">月次返済ID</th>
              <th scope="col">掛取引ID</th>
              <th scope="col">対象取引先</th>
              <th scope="col">支払い対象月</th>
              <th scope="col">入金金額</th>
              <th scope="col">支払い遅延</th>
              <th scope="col">月次返済登録日時</th>
              <th scope="col">最終更新日時</th>
              <th scope="col">削除</th>
    
              </tr>
          </thead>
          <tbody>

            @foreach($repayments as $repayment)
              <tr>
                <td>{{ $repayment->id }}</td>
                <td>{{ $repayment->trade_id }}</td>
                <td>{{ $repayment->trades->clients->client_name ??''}}</td>
                <td>{{ $repayment->payment_month }}</td>
                <td>{{ $repayment->amount }}</td>

                @if ($repayment->delay_flag=="yes")
                <td>あり</td>
                @elseif ($repayment->delay_flag=="no")
                <td>なし</td>
                @endif

                <td>{{ $repayment->created_at }}</td>
                <td>{{ $repayment->updated_at }}</td>
                <td><a href="{{ route('confirm_repayment', ['id' => $repayment->id]) }}">🗑</a></td>
              </tr>
          @endforeach
          
          </tbody>
        </table>
      </div>
    </div>
    @endsection
    
      
</body>
</html>