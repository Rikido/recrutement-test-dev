@extends('layouts.app')

@section('group_index')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">グループ一覧画面</div>

                @foreach($groups as $group)
                <div class="card-body">
                    {{ $group->group_name }}
                </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
@endsection