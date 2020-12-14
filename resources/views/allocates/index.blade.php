@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">部材割当履歴一覧</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>部材名</th>
                                <th>割当先名</th>
                                <th>割当個数</th>
                                <th>割当日</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allocates as $allocate)
                                <tr>
                                    <td>
                                        <a href="{{route('allocate.create', ['id' => $allocate->item->id])}}">
                                            {{ $allocate->item->item_name }}
                                        </a>
                                    </td>
                                    <td>{{ $allocate->name }}</td>
                                    <td>{{ $allocate->num }}</td>
                                    <td>{{ $allocate->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div style="display:inline-block; padding: 20px 300px;">
                        {{ $allocates->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection