<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>月次返済処理登録</title>
  <link rel="stylesheet" href="{{ asset('css/add_clients.css') }}">
</head>
<body>

  @include('shared.shared_header')
    
    <h1>月次返済処理登録</h1>
    
    @if($errors->any())
    <div class="alert-danger">
      @foreach($errors->all() as $error)
        {{ $error }}<br/>
      @endforeach
    </div>
    @endif
  
    <form method="post" action="{{ route('register_repayment', $trade->id) }}">
    
      @csrf
  
      <div class="client-name">
        <div name="client_name">
         <h2>{{ $client->client_name }}</h2>
         <h2>掛取引ID:{{ $trade->id }}</h2>
        </div>
      </div>
  
      <div class="trade-id">
        <label for="trade-id"></label>
        <div class="input-form">
          <input type="hidden" name="trade_id" class="trade-id-text" placeholder="掛取引id" value="{{ $trade->id }}">
        </div>
      </div>
  
      <div class="payment-month">
        <label for="payment_month">入金対象月</label>
        <div class="input-form">
          <input type="month" name="payment_month" class="payment-month-text" placeholder="入金対象月" value>
        </div>
      </div>
  
      <div class="amount">
        <label for="amount">入金額</label>
        <div class="input-form">
          <input type="number" name="amount" class="amount-text" placeholder="入金額" value>
        </div>
      </div>
  
      <div class="delay-flag">遅延フラグ</br>
          <input type="radio" name="delay_flag" value="yes">あり
          <input type="radio" name="delay_flag" value="no">なし
      </div>
  
      <div class="credit-minus">
        <label for="credit_minus"></label>
        <div class="input-form">

          @if($trade->transaction_amount <= 1000000 && $trade->months_of_term <= 6)
            <input type="hidden" name="credit_minus" class="credit-minus-text" placeholder="信用スコア減点" value="-20">
          @elseif($trade->transaction_amount <= 1000000 && $trade->months_of_term > 6 && $trade->months_of_term <= 12)
            <input type="hidden" name="credit_minus" class="credit-minus-text" placeholder="信用スコア減点" value="-30">
          @elseif($trade->transaction_amount <= 1000000 && $trade->months_of_term > 12 && $trade->months_of_term <= 36)
            <input type="hidden" name="credit_minus" class="credit-minus-text" placeholder="信用スコア減点" value="-40">
          @elseif($trade->transaction_amount <= 1000000 && $trade->months_of_term > 36 && $trade->months_of_term <= 60)
            <input type="hidden" name="credit_minus" class="credit-minus-text" placeholder="信用スコア減点" value="-50">
          @elseif($trade->transaction_amount <= 1000000 && $trade->months_of_term > 60 && $trade->months_of_term <= 84)
            <input type="hidden" name="credit_minus" class="credit-minus-text" placeholder="信用スコア減点" value="-60">
          @elseif($trade->transaction_amount > 1000000 && $trade->transaction_amount <= 10000000 && $trade->months_of_term <= 6)
            <input type="hidden" name="credit_minus" class="credit-minus-text" placeholder="信用スコア減点" value="-5">
          @elseif($trade->transaction_amount > 1000000 && $trade->transaction_amount <= 10000000 && $trade->months_of_term > 6 && $trade->months_of_term <= 12)
            <input type="hidden" name="credit_minus" class="credit-minus-text" placeholder="信用スコア減点" value="-10">
          @elseif($trade->transaction_amount > 1000000 && $trade->transaction_amount <= 10000000 && $trade->months_of_term > 12 && $trade->months_of_term <= 36)
            <input type="hidden" name="credit_minus" class="credit-minus-text" placeholder="信用スコア減点" value="-20">
          @elseif($trade->transaction_amount > 1000000 && $trade->transaction_amount <= 10000000 && $trade->months_of_term > 36 && $trade->months_of_term <= 60)
            <input type="hidden" name="credit_minus" class="credit-minus-text" placeholder="信用スコア減点" value="-30">
          @elseif($trade->transaction_amount > 1000000 && $trade->transaction_amount <= 10000000 && $trade->months_of_term > 60 && $trade->months_of_term <= 84)
            <input type="hidden" name="credit_minus" class="credit-minus-text" placeholder="信用スコア減点" value="-40">
          @elseif($trade->transaction_amount > 10000000 && $trade->transaction_amount <= 50000000 && $trade->months_of_term <= 6)
            <input type="hidden" name="credit_minus" class="credit-minus-text" placeholder="信用スコア減点" value="-3">
          @elseif($trade->transaction_amount > 10000000 && $trade->transaction_amount <= 50000000 && $trade->months_of_term > 6 && $trade->months_of_term <= 12)
            <input type="hidden" name="credit_minus" class="credit-minus-text" placeholder="信用スコア減点" value="-5">
          @elseif($trade->transaction_amount > 10000000 && $trade->transaction_amount <= 50000000 && $trade->months_of_term > 12 && $trade->months_of_term <= 36)
            <input type="hidden" name="credit_minus" class="credit-minus-text" placeholder="信用スコア減点" value="-10">
          @elseif($trade->transaction_amount > 10000000 && $trade->transaction_amount <= 50000000 && $trade->months_of_term > 36 && $trade->months_of_term <= 60)
            <input type="hidden" name="credit_minus" class="credit-minus-text" placeholder="信用スコア減点" value="-20">
          @elseif($trade->transaction_amount > 10000000 && $trade->transaction_amount <= 50000000 && $trade->months_of_term > 60 && $trade->months_of_term <= 84)
            <input type="hidden" name="credit_minus" class="credit-minus-text" placeholder="信用スコア減点" value="-30">
          @elseif($trade->transaction_amount > 50000000 && $trade->transaction_amount <= 100000000 && $trade->months_of_term <= 6)
            <input type="hidden" name="credit_minus" class="credit-minus-text" placeholder="信用スコア減点" value="-1">
          @elseif($trade->transaction_amount > 50000000 && $trade->transaction_amount <= 100000000 && $trade->months_of_term > 6 && $trade->months_of_term <= 12)
            <input type="hidden" name="credit_minus" class="credit-minus-text" placeholder="信用スコア減点" value="-3">
          @elseif($trade->transaction_amount > 50000000 && $trade->transaction_amount <= 100000000 && $trade->months_of_term > 12 && $trade->months_of_term <= 36)
            <input type="hidden" name="credit_minus" class="credit-minus-text" placeholder="信用スコア減点" value="-5">
          @elseif($trade->transaction_amount > 50000000 && $trade->transaction_amount <= 100000000 && $trade->months_of_term > 36 && $trade->months_of_term <= 60)
            <input type="hidden" name="credit_minus" class="credit-minus-text" placeholder="信用スコア減点" value="-10">
          @elseif($trade->transaction_amount > 50000000 && $trade->transaction_amount <= 100000000 && $trade->months_of_term > 60 && $trade->months_of_term <= 84)
            <input type="hidden" name="credit_minus" class="credit-minus-text" placeholder="信用スコア減点" value="-20">
          @elseif($trade->transaction_amount > 100000000 && $trade->transaction_amount <= 1000000000 && $trade->months_of_term <= 6)
            <input type="hidden" name="credit_minus" class="credit-minus-text" placeholder="信用スコア減点" value="0">
          @elseif($trade->transaction_amount > 100000000 && $trade->transaction_amount <= 1000000000 && $trade->months_of_term > 6 && $trade->months_of_term <= 12)
            <input type="hidden" name="credit_minus" class="credit-minus-text" placeholder="信用スコア減点" value="-1">
          @elseif($trade->transaction_amount > 100000000 && $trade->transaction_amount <= 1000000000 && $trade->months_of_term > 12 && $trade->months_of_term <= 36)
            <input type="hidden" name="credit_minus" class="credit-minus-text" placeholder="信用スコア減点" value="-3">
          @elseif($trade->transaction_amount > 100000000 && $trade->transaction_amount <= 1000000000 && $trade->months_of_term > 36 && $trade->months_of_term <= 60)
            <input type="hidden" name="credit_minus" class="credit-minus-text" placeholder="信用スコア減点" value="-5">
          @elseif($trade->transaction_amount > 100000000 && $trade->transaction_amount <= 1000000000 && $trade->months_of_term > 60 && $trade->months_of_term <= 84)
            <input type="hidden" name="credit_minus" class="credit-minus-text" placeholder="信用スコア減点" value="-10">
          @endif

        </div>
      </div>

      <button type="submit" class="submit-btn">登録</button>
    </from>
  
  </div>
    
</body>
</html>