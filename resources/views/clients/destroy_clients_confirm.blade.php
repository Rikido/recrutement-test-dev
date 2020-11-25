<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>取引先削除</title>
  <link rel="stylesheet" href="{{ asset('css/add_clients.css') }}">
</head>
<body>

  @include('shared.shared_header')

  <div class="edit-clients">
  
    <h1>取引先削除</h1>
    <h2>{{ $client->client_name }}</h2>

    @if($errors->any())
    <div class="alert-danger">
      @foreach($errors->all() as $error)
        {{ $error }}<br/>
      @endforeach
    </div>
    @endif

    <form action="{{ route('destroy_client', $client->id) }}" method="POST">
      @method('DELETE')
      @csrf

      <div class="client-name">
        <div class="client_name">取引先名:</div>
          <div class="client-text">{{$client->client_name}}</div>
      </div>

      <div class="capital-amount">
        <div class="capital_amount">資本金額:</div>
          <div class="capital-text">{{$client->capital_amount}}</div>
      </div>

      <div class="annual-sales">
        <div class="annual_sales_1">売上高(前期):</div>
        <div class="sales-text">{{$client->annual_sales_1}}</div>
      </div>
      
      <div class="annual-sales">
        <div class="annual_sales_2">売上高(前々期):</div>
        <div class="sales-text">{{$client->annual_sales_2}}</div>
      </div>
      
      <div class="annual-sales">
        <div class="annual_sales_3">売上高(前々々期):</div>
          <div class="sales-text">{{$client->annual_sales_3}}</div>
      </div>
      
      <div class="credit-score">
        <div class="credit_score">信用スコア:</div>
          <div class="credit-text">{{$client->credit_score}}</div>
      </div>

      <button type="submit" class="submit-btn">削除</button>
    </from>

  </div>

</body>
</html>