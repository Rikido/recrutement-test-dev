<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>掛取引登録</title>
  <link rel="stylesheet" href="{{ asset('css/add_clients.css') }}">
</head>
<body>

  @include('shared.shared_header')

  <div class="new-trades">

  <h1>掛取引登録</h1>
    
    @if($errors->any())
    <div class="alert-danger">
      @foreach($errors->all() as $error)
        {{ $error }}<br/>
      @endforeach
    </div>
    @endif
  
    <form method="post" action="{{ route('register_trade', $client->id) }}">
    
      @csrf
  
      <div class="client-name">
        <div name="client_name">
         <h2>{{ $client->client_name }}</h2>
        </div>
      </div>
  
      <div class="client-id">
        <label for="client-id"></label>
        <div class="input-form">
          <input type="hidden" name="client_id" class="transaction-text" placeholder="取引先id" value="{{ $id }}">
        </div>
      </div>
  
      <div class="transaction-amount">
        <label for="transaction_amount">掛取引金額</label>
        <div class="input-form">
          <input type="number" name="transaction_amount" class="transaction-text" placeholder="掛取引金額" value>
        </div>
      </div>
  
      <div class="months-of-term">
        <label for="months_of_term">返済期間月数</label>
        <div class="input-form">
          <input type="number" name="months_of_term" class="months-text" placeholder="返済期間月数" value>
        </div>
      </div>
  
      <div class="trade-score">
        <label for="trade_score"></label>
        <div class="input-form">
          <input type="hidden" name="trade_score" class="trade-score-text" placeholder="掛取引信用スコア" value=100>
        </div>
      </div>

      <button type="submit" class="submit-btn">登録</button>
    </from>
  
  </div>
  
</body>
</html>