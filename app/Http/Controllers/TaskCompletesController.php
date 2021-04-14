<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\TaskCharge;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TaskCompletesController extends Controller
{
    // 工事担当箇所実施報告画面
    public function create($project_id, $task_charge_id) {
        $project = Project::findOrFail($project_id);
        $file_name = str_replace('public/', '', $project->file_path);
        $task_charge = TaskCharge::findOrFail($task_charge_id);
        $auths = Auth::user();
        // URL直打ち対策
        if($auths->id === $task_charge->user->id) {
            // ログインユーザーと担当情報のユーザーIDが一致していれば報告画面へ
            return view('task_completes.create', compact('project', 'task_charge', 'file_name'));
        }
        // 一致しなければ進行プラン詳細画面へリダイレクト
        return redirect()->action('ProjectsController@show', ['id' => $project->id]);
    }

    // 工事担当箇所実施報告画面の入力値を登録する処理
    public function register($project_id, $task_charge_id, Request $request) {
        $project = Project::findOrFail($project_id);
        $task_charge = TaskCharge::findOrFail($task_charge_id);
        // 検査報告の登録
        $task_charge->report = $request->report;
        // 報告日時の登録
        $task_charge->reported_at = new Carbon('now');
        $task_charge->save();
        return redirect()->action('ProjectsController@complete', ['project_id' => $project->id, 'task_charge_id' => $task_charge->id]);
    }

    // 工事担当箇所実施報告提出完了画面
    public function complete($project_id, $task_charge_id) {
        return view('task_completes.complete');
    }
}
