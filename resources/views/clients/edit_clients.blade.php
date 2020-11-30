<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>取引先編集</title>
  <link rel="stylesheet" href="{{ asset('css/add_clients.css') }}">
</head>
<body>

  @include('shared.shared_header')

  <div class="edit-clients">
  
    <h1>取引先編集</h1>
    <h2>{{ $client->client_name }}</h2>

    @if($errors->any())
    <div class="alert-danger">
      @foreach($errors->all() as $error)
        {{ $error }}<br/>
      @endforeach
    </div>
    @endif

    <form action="{{ route('update_client', $client->id) }}" method="POST">
      @method('PUT')
      @csrf

      <div class="client-name">
        <label for="client_name">取引先名</label>
        <div class="input-form">
          <input type="text" name="client_name" class="client-text" value="{{$client->client_name}}">
        </div>
      </div>

      <div class="capital-amount">
        <label for="capital_amount">資本金額</label>
        <div class="input-form">
          <input type="text" name="capital_amount" class="capital-text" value="{{$client->capital_amount}}">
        </div>
      </div>

      <div class="annual-sales">
        <label for="annual_sales_1">売上高(前期)</label>
        <div class="input-form">
          <input type="text" name="annual_sales_1" class="sales-text" value="{{$client->annual_sales_1}}">
        </div>
      </div>
      
      <div class="annual-sales">
        <label for="annual_sales_2">売上高(前々期)</label>
        <div class="input-form">
          <input type="text" name="annual_sales_2" class="sales-text" value="{{$client->annual_sales_2}}">
        </div>
      </div>
      
      <div class="annual-sales">
        <label for="annual_sales_3">売上高(前々々期)</label>
        <div class="input-form">
          <input type="text" name="annual_sales_3" class="sales-text" value="{{$client->annual_sales_3}}">
        </div>
      </div>
      
      <div hidden class="credit-score">
        <label for="credit_score"></label>
        <div class="input-form">
          <input type="number" name="credit_score" class="credit-text" value="{{$client->credit_score}}">
        </div>
      </div>

      <button type="submit" class="submit-btn">編集</button>
    </from>

  </div>

</body>
</html>