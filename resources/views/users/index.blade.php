@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card-body">
				<div class="card-header">社員一覧</div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>社員番号</th>
                                <th>社員名</th>
                                <th>入社年月日</th>
                                <th>年齢</th>
                                <th>登録日時</th>
                                <th>更新日時</th>
                            </tr>
                        </thead>
                        <tbody>
							 @foreach($users as $user)
                                <tr>

                                    <td>
										{{$user->employee_code}}
                                    </td>
                                    <td>
										{{$user->name}}
                                    </td>
                                    <td>
										{{$user->employment_date}}
                                    </td>
                                    <td>
										{{$user->birth_day}}
                                    </td>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                </tr>
                              @endforeach
                        </tbody>
                    </table>
               </div>
		</div>
	</div>
</div>
@endsection