@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">部材入庫履歴一覧</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>部材名</th>
                                <th>入庫個数</th>
                                <th>入庫日</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($receipts as $receipt)
                                <tr>
                                    <td>
                                        <a href="{{route('receipt.create', ['id' => $receipt->item->id])}}">
                                            {{ $receipt->item->item_name }}
                                        </a>
                                    </td>
                                    <td>{{ $receipt->num }}</td>
                                    <td>{{ $receipt->created_at }}</td>
                                    <td><a href="{{route('allocate.create', ['id' => $receipt->item->id])}}">割当入力へ</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div style="display:inline-block; padding: 20px 300px;">
                        {{ $receipts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection