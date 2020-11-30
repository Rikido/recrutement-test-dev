<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>月次返済処理削除</title>
  <link rel="stylesheet" href="{{ asset('css/add_clients.css') }}">
</head>
<body>

  @include('shared.shared_header')

  <div class="edit-clients">
  
    <h1>月次返済処理削除</h1>
    <h2>{{ $client->client_name }}</h2>

    @if($errors->any())
    <div class="alert-danger">
      @foreach($errors->all() as $error)
        {{ $error }}<br/>
      @endforeach
    </div>
    @endif

    <form action="{{ route('destroy_repayment', $repayment->id) }}" method="POST">
      @method('DELETE')
      @csrf

      <div class="trade-id">
        <div class="trade_id">掛取引ID:</div>
          <div class="trade-id-text">{{$trade->client_id}}</div>
      </div>

      <div class="payment-month">
        <div class="payment_month">入金対象月:</div>
          <div class="payment-month-text">{{$repayment->payment_month}}</div>
      </div>

      <div class="amount">
        <div class="amount">入金額:</div>
        <div class="amount-text">{{$repayment->amount}}</div>
      </div>

      <div class="months-of-term">
        <div class="months_of_term">遅延フラグ:</div>
        @if($repayment->delay_flag=="yes")
        <div class="months-text">あり</div>
        @elseif($repayment->delay_flag=="no")
        <div class="months-text">なし</div>
        @endif
      </div>

      <button type="submit" class="submit-btn">削除</button>
    </from>

  </div>

</body>
</html>