<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\TaskCharge;
use Carbon\Carbon;

class TaskChargeCompletesController extends Controller
{
    //工事担当箇所実施報告
    public function create($project_id, $task_charge_id) {
        $task_charge = TaskCharge::findOrFail($task_charge_id);
        $project = Project::findOrFail($project_id);

        return view('task_charge_completes/create', compact('project', 'task_charge'));
    }

    //工事担当箇所実施報告の値を保存
    public function createStore($project_id, $task_charge_id, Request $request) {
        $project = Project::findOrFail($project_id);
        $task_charge = TaskCharge::findOrFail($task_charge_id);
        $task_charge->report = $request->report;
        $task_charge->reported_at = new Carbon('now');
        $task_charge->save();

        return redirect()->action('TaskChargeCompletesController@complete', ['project_id' => $project->id, 'task_charge_id' => $task_charge->id]);
    }

    //工事担当箇所実施報告提出完了
    public function complete($project_id, $task_charge_id) {
        return view('task_charge_completes/complete');
    }
}
