@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">部材割当画面</div>
                <div class="card-body">
                    <form method="POST" action="{{route('allocate.store')}}">
                    @csrf
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>部材名</td>
                                <td>{{ $item->item_name }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>割当個数</td>
                                <td><input type="number" name="num" min="1" max="1000" class="form-control"></td>
                                <td>（割当可能数:{{ $num }} 個）</td>
                            </tr>
                            <tr>
                                <td>割当先名</td>
                                <td><input type="text" name="name" class="form-control"></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                    @if ($num <= 0) 
                        <p class="num-alert" style="color: red; text-align: center;">※割当可能個数がありません</p>
                    @endif
                    <input type="hidden" name="item_id" value="{{ $item->id }}">

                    <input type="submit" class="btn btn-info text-right" value="割当">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-10" style="margin-top: 50px;">
        <div class="card">
            <div class="card">
                <div class="card-header">割当履歴</div>
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
                            @foreach($item->allocates as $allocate)
                                <tr>
                                    <td>{{ $allocate->item->item_name }}</td>
                                    <td>{{ $allocate->name }}</td>
                                    <td>{{ $allocate->num }} 個</td>
                                    <td>{{ $allocate->created_at }}</td>
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