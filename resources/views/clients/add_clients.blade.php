<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>取引先登録</title>
  <link rel="stylesheet" href="{{ asset('css/add_clients.css') }}">
</head>
<body>

  @include('shared.shared_header')

  <div class="new-clients">
  
    <h1>取引先登録</h1>

    @if($errors->any())
    <div class="alert-danger">
      @foreach($errors->all() as $error)
        {{ $error }}<br/>
      @endforeach
    </div>
    @endif

    <form method="post" action="/clients/register">
    
      @csrf

      <div class="client-name">
        <label for="client_name">取引先名</label>
        <div class="input-form">
          <input type="text" name="client_name" class="client-text" placeholder="取引先名" value>
        </div>
      </div>

      <div class="capital-amount">
        <label for="capital_amount">資本金額</label>
        <div class="input-form">
          <input type="number" name="capital_amount" class="capital-text" placeholder="資本金額" value>
        </div>
      </div>

      <div class="annual-sales">
        <label for="annual_sales_1">売上高(前期)</label>
        <div class="input-form">
          <input type="number" name="annual_sales_1" class="sales-text" placeholder="売上高(前期)" value>
        </div>
      </div>
      
      <div class="annual-sales">
        <label for="annual_sales_2">売上高(前々期)</label>
        <div class="input-form">
          <input type="number" name="annual_sales_2" class="sales-text" placeholder="売上高(前々期)" value>
        </div>
      </div>
      
      <div class="annual-sales">
        <label for="annual_sales_3">売上高(前々々期)</label>
        <div class="input-form">
          <input type="number" name="annual_sales_3" class="sales-text" placeholder="売上高(前々々期)" value>
        </div>
      </div>
      
      <div hidden class="credit-score">
        <label for="credit_score"></label>
        <div class="input-form">
          <input type="number" name="credit_score" class="credit-text" value=65>
        </div>
      </div>

      <button type="submit" class="submit-btn">登録</button>
    </from>

  </div>

</body>
</html>