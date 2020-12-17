<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;


class AttendanceController extends Controller
{

    public function create($id) {

        $carbon = new Carbon();
        $n = 0;

        $format = 'DD (ddd)';
        $last_day = $carbon->lastOfMonth()->day. "\n";
        $days = array();
        for($i = 0; $i < $last_day; $i++){
            if($carbon->firstOfMonth()->day. "\n" == '1'){
                $days[$i] = $carbon->firstOfMonth()->isoFormat($format);
            }else{
                $days[$i] = $carbon->addDay($i)->isoFormat($format);
            }
        }
        return view('attendance.create',compact('carbon','n','days'));
    }

    public function beforeCreate($id, $n) {

        $carbon = new Carbon($n.'months');

        return view('attendance.create',compact('carbon','n'));
    }

    public function afterCreate($id, $n) {

        $carbon = new Carbon($n.'months');

        return view('attendance.create',compact('carbon','n'));
    }

    public function store(Request $request, $id) {

        $attendance = new Attendance;
        echo $comment->post->title;
        //初めて登録するときの処理（登録日時保存）
        if($user->employee_code == null){
            $now = date("Y-m-d H:i:s");
            $user->employee_code = $request->input('employee_code');
            $user->employee_name = $request->input('employee_name');
            $user->employment_date = $request->input('employment_date');
            $user->birth_day = $request->input('birth_day');
            $user->email = $request->input('email');
            $user->created_at = $now;
            $user->save();
            return back()->with('message', '社員情報を登録しました。');
        }else{
            $user->employee_code = $request->input('employee_code');
            $user->employee_name = $request->input('employee_name');
            $user->employment_date = $request->input('employment_date');
            $user->birth_day = $request->input('birth_day');
            $user->email = $request->input('email');
            $user->save();
            r




        return redirect('/')->with('message', '部材を登録しました。');

    }
}
