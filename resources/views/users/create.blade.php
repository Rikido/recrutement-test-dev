@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
    			<div class="card-body">
    				<div class="card-header">社員情報登録・編集画面</div>

						<form action="{{ route('user.store', $user->id) }}" method="post">
						@csrf
							<div class="form-group">
								社員番号<br>
								<input type="text" name="employee_code" value="{{ $user->employee_code }}">
							</div>
                            <div class="form-group">
                            	社員名<br>
                            	<input type="text" name="employee_name" value="{{ $user->employee_name }}">
                            </div>
                            <div class="form-group">
                            	入社年月日<br>
                            	<input type="date" name="employment_date" value="{{ $user->employment_date }}">
                            </div>
                            <div class="form-group">
                            	生年月日<br>
                            	<input type="date" name="birth_day" value="{{ $user->birth_day }}">
                            </div>
                            <div class="form-group">
                            	Email<br>
                            	{{ $user->email }}
                            </div>
                            <div class="form-group">
                            	パスワード<br>
                            	{{ $user->password }}
                            </div>
                            <input class="btn btn-success" type="submit" value="送信">
                         </form>

                    </div>
               </div>
		</div>
	</div>
</div>
@endsection