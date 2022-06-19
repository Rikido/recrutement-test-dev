<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\TaskCharge;
use Carbon\Carbon;

class TaskChargeCompletesController extends Controller
{
    //工事担当箇所実施報告
    public function create($id, $task_charge_id) {
        $task_charge = TaskCharge::findOrFail($task_charge_id);
        $project = $task_charge->project;

        return view('task_charge_completes/create', compact('project', 'task_charge'));
    }

    //工事担当箇所実施報告の値を保存
    public function createStore() {
        //
        return redirect()->action('ProjectsController@complete');
    }

    //工事担当箇所実施報告提出完了
    public function complete() {
        //
    }
}
