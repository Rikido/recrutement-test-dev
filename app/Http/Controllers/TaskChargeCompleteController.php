<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TaskChargeCompleteStoreFormRequest;
use App\Task_charge;
use App\Project;
use Carbon\Carbon;

class TaskChargeCompleteController extends Controller
{
    //
    public function create($id, $task_charge_id)
    {
        $task_charge = Task_charge::findOrFail($task_charge_id);
        $project = $task_charge->project;

        session()->put(["id" => $id, "task_charge_id" => $task_charge_id]);
        return view('task_charge_complete.create', compact('project', 'task_charge'));
    }


    public function store(TaskChargeCompleteStoreFormRequest $request)
    {
        $id = $request->session()->get("id");
        $task_charge_id = $request->session()->get("task_charge_id");
        $report = $request->report;
        $task_charge = Task_charge::findOrFail($task_charge_id);
        $task_charge->report = $report;
        $task_charge->reported_at = new Carbon('now');
        $task_charge->save();

        return redirect()->action('TaskChargeCompleteController@complete');
    }

    public function complete()
    {
        return view('task_charge_complete.complete');
    }
}
