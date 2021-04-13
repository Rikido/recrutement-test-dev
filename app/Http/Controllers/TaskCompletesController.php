<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\TaskCharge;

class TaskCompletesController extends Controller
{
    public function create($project_id, $task_charge_id) {
        $project = Project::findOrFail($project_id);
        $task_charge = TaskCharge::findOrFail($task_charge_id);

        return view('task_completes.create', compact('project', 'task_charge'));
    }
}
