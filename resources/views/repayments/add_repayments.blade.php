<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>月次返済処理登録</title>
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
  
    <form method="post" action="/repayments/register">
    
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
  
      <div class="delay-flag">
        <label for="delay_flag">遅延フラグ</label>
        <div class="input-form">
          <input type="checkbox" name="delay_flag" class="delay-text" value="yes"> あり
          <input type="checkbox" name="delay_flag" class="delay-text" value="no"> なし
        </div>
      </div>

      <button type="submit" class="submit-btn">登録</button>
    </from>
  
  </div>
    
</body>
</html>