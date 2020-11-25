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

    @if($errors->any())
    <div class="alert-danger">
      @foreach($errors->all() as $error)
        {{ $error }}<br/>
      @endforeach
    </div>
    @endif

    <form action="{{ route('update_repayment', $repayment->id) }}" method="POST">
      @method('PUT')
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
          <input type="month" name="payment_month" class="payment-month-text" placeholder="入金対象月" value="{{ $repayment->payment_month }}">
        </div>
      </div>
    
      <div class="amount">
        <label for="amount">入金額</label>
        <div class="input-form">
          <input type="number" name="amount" class="amount-text" placeholder="入金額" value="{{ $repayment->amount }}">
        </div>
      </div>
    
      <div class="delay-flag">
        <label for="delay_flag">遅延フラグ</label>
        <div class="input-form">
          <input type="checkbox" name="delay_flag" class="delay-text" value="yes" @if( $repayment->delay_flag == "yes" ) checked @endif> あり
          <input type="checkbox" name="delay_flag" class="delay-text" value="no" @if( $repayment->delay_flag == "no" ) checked @endif> なし
        </div>
      </div>
    
      <button type="submit" class="submit-btn">編集</button>
    </from>

  </div>

</body>
</html>