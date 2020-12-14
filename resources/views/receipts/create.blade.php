@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">部材入庫画面</div>
                <div class="card-body">
                    <form method="POST" action="{{route('receipt.store')}}">
                    @csrf
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>{{ $item->item_name }}</th>
                                <td><input type="number" name="num" min="1" max="1000" class="form-control"></td>
                                <td>入庫可能個数　{{ $num }} 個</td>
                            </tr>
                        </tbody>
                    </table>
                    @if ($num <= 0) 
                        <p class="num-alert" style="color: red; text-align: center;">※入庫可能個数がありません</p>
                    @endif
                    <input type="hidden" name="item_id" value="{{ $item->id }}">

                    <input type="submit" class="btn btn-info text-right" value="入庫">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-10" style="margin-top: 50px;">
            <div class="card">
                <div class="card-header">入庫履歴</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>部材名</th>
                                <th>入庫日</th>
                                <th>入庫個数</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($item->receipts as $receipt)
                                <tr>
                                    <td>{{ $receipt->item->item_name }}</td>
                                    <td>{{ $receipt->created_at }}</td>
                                    <td>{{ $receipt->num }} 個</td>
                                </tr>
                            @endforeach
                        </tbody>    
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection