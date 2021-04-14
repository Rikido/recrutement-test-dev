<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\TaskCharge;
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
}
