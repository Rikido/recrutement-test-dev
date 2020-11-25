<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>掛取引編集</title>
  <link rel="stylesheet" href="{{ asset('css/add_clients.css') }}">
</head>
<body>

  @include('shared.shared_header')

  <div class="edit-clients">
  
    <h1>掛取引編集</h1>
    <h2>{{ $client->client_name }}</h2>

    @if($errors->any())
    <div class="alert-danger">
      @foreach($errors->all() as $error)
        {{ $error }}<br/>
      @endforeach
    </div>
    @endif

    <form action="{{ route('update_trade', $trade->id) }}" method="POST">
      @method('PUT')
      @csrf

      <div hidden class="client-id">
        <label for="client_id">取引先id</label>
        <div class="input-form">
          <input type="text" name="client_id" class="client-id-text" value="{{$trade->client_id}}">
        </div>
      </div>

      <div class="transaction-amount">
        <label for="transaction_amount">取引金額</label>
        <div class="input-form">
          <input type="text" name="transaction_amount" class="transaction-text" value="{{$trade->transaction_amount}}">
        </div>
      </div>

      <div class="months-of-term">
        <label for="months_of_term">返済期間月数</label>
        <div class="input-form">
          <input type="text" name="months_of_term" class="months-text" value="{{$trade->months_of_term}}">
        </div>
      </div>

      <button type="submit" class="submit-btn">編集</button>
    </from>

  </div>

</body>
</html>