<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>掛取引削除</title>
  <link rel="stylesheet" href="{{ asset('css/add_clients.css') }}">
</head>
<body>

  @include('shared.shared_header')

  <div class="edit-clients">
  
    <h1>掛取引削除</h1>
    <h2>{{ $trade->id }}</h2>

    @if($errors->any())
    <div class="alert-danger">
      @foreach($errors->all() as $error)
        {{ $error }}<br/>
      @endforeach
    </div>
    @endif

    <form action="{{ route('destroy_trade', $trade->id) }}" method="POST">
      @method('DELETE')
      @csrf

      <div class="client-id">
        <div class="client_id">取引先ID:</div>
          <div class="client-id-text">{{$trade->client_id}}</div>
      </div>

      <div class="transaction-amount">
        <div class="transaction_amount">取引金額:</div>
          <div class="transaction-text">{{$trade->transaction_amount}}</div>
      </div>

      <div class="months-of-term">
        <div class="months_of_term">返済期間月数:</div>
        <div class="months-text">{{$trade->months_of_term}}</div>
      </div>

      <button type="submit" class="submit-btn">削除</button>
    </from>

  </div>

</body>
</html>