@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">部材発注履歴一覧</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>部材名</th>
                                <th>発注個数</th>
                                <th>発注日</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchases as $purchase)
                                <tr>
                                    <td>
                                        <a href="{{ route('purchase.create', ['id' => $purchase->item->id]) }}">
                                            {{ $purchase->item->item_name }}
                                        </a>
                                    </td>
                                    <td>{{ $purchase->num }}</td>
                                    <td>{{ $purchase->created_at }}</td>
                                    <td><a href="{{route('receipt.create', ['id' => $purchase->item->id])}}">入庫入力へ</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div style="display:inline-block; padding: 20px 300px;">
                        {{ $purchases->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection