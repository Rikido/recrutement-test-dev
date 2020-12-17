@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ Auth::user()->name }}さん　月次の勤怠実績一覧登録・編集画面</div>
                	<div class="card-body">
                		<?php
                		  echo $carbon->year . "\n"."年";
                		?>
                		<h4 class="text-center"><?php echo $carbon->month . "\n"."月"; ?></h4>
                		<h5 class="text-left">
                			<a href="{{route('attendance.create.before', ['id' => Auth::user()->id, 'n' => $n - 1])}}">
                				前の月
                			</a>
                		</h5>
                		<h5 class="text-right">
                			<a href="{{route('attendance.create.after', ['id' => Auth::user()->id, 'n' => $n + 1])}}">
                				次の月
                			</a>
                		</h5>
                		<table class="table">
                			<thead>
								<tr>
									<th>日付</th>
									<th>出勤時刻</th>
									<th>退勤時刻</th>
									<th>休憩時間</th>
									<th>備考</th>
									<th>有給申請ボタン</th>
									<th>修正内容コメント欄</th>
								</tr>
                			</thead>
                			<tbody>
                    			@foreach($days as $day)
                    				<form action="{{ route('attendance.store', Auth::user()->id) }}" method="post">
                        				<tr>
                        					<th><?php echo $day; ?></th>
                        					<th>
                        						<input type="time" name="in_time">
                        					</th>
                        					<th>
                        						<input type="time" name="up_time">
                        					</th>
                        					<th>
                        						<input type="time" name="break_time">
                        					</th>
                        					<th>
                        						<input type="text" name="comment">
                        					</th>
                        					<th><input type="submit" class="btn btn-info" value="登録"></th>
                        				</tr>
                        			</form>
                    			@endforeach
                			</tbody>
                		</table>
                		<table class="table">
                			<thead>
                				<tr>
                					<th>当月の合計勤務時間</th>
                					<th>当月の合計残業時間</th>
                					<th>残有給日数</th>
                					<th>遅刻回数</th>
                					<th>早退回数</th>
                				</tr>
                			</thead>
                			<tbody>
                				<tr>
                				</tr>
                			</tbody>
                		</table>






                	</div>
            </div>
        </div>
    </div>
</div>
@endsection
