@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
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
    										{{$user->employee_name}}
                                        </td>
                                        <td>
    										{{$user->employment_date}}
                                        </td>
                                        <td>
                                        <?php
                                            $currentDate = date('Y/m/d');
                                            $birthday = $user->birth_day;
                                            $c = (int)date('Ymd', strtotime($currentDate));
                                            $b = (int)date('Ymd', strtotime($birthday));
                                            if($birthday == null){
                                                echo "未設定";
                                            }else{
                                                $age = (int)(($c - $b) / 10000);
                                                echo $age;
                                            }

                                        ?>
                                        </td>
                                        <td>
											{{$user->created_at}}
                                        </td>
                                        <td>
											{{$user->updated_at}}
                                        </td>
                                    </tr>
                                  @endforeach
                            </tbody>
                        </table>
                   </div>
               </div>
              <div class="mx-auto" style="width: 100px;">{{ $users->links() }}</div>
		</div>
	</div>
</div>
@endsection