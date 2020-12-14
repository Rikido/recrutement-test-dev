@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">部材発注画面</div>
                <div class="card-body">
                    <form method="POST" action="{{route('purchase.store')}}">
                    @csrf
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>{{ $item->item_name }}</th>
                                <td><input type="number" name="num" style="width:70%;" min="1" max="1000"　class="form-control"></td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                    <input type="submit" class="btn btn-info" value="発注">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-10" style="margin-top: 50px;">
            <div class="card">
                <div class="card-header">発注履歴</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>部材名</th>
                                <th>発注日</th>
                                <th>発注個数</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($item->purchases as $purchase)
                                <tr>
                                    <td>{{ $purchase->item->item_name }}</td>
                                    <td>{{ $purchase->created_at }}</td>
                                    <td>{{ $purchase->num }} 個</td>
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