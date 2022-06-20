@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!<br>
                    <a href="{{ url('projects/create') }}" class="btn btn-secondary mt-3">新規案件の登録</a>
                    <a href="{{ url('projects/') }}" class="btn btn-secondary mt-3 ml-3">案件一覧</a>
                    <a href="{{ url('groups/') }}" class="btn btn-secondary mt-3 ml-3">グループ一覧</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
