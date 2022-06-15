<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Project;
use App\Resource;
use App\ResourceStock;

class ProgressPlansController extends Controller
{
    //利用資材入力
    public function resource($id) {
        $project = Project::with('group.users')->find($id);
        $resources = Resource::all();
        session()->put('project', $project);

        return view('progress_plans/resource', compact('project', 'resources'));
    }

    //利用資材入力の値を保存
    public function resourceStore($id, Request $request) {
        $project = Project::with('group.users')->find($id);
        $project_resource_input = $request->input('project_resources');
        //10項目までで空の場合も考えられるため、$project_resource_inputから空の配列を削除する
        //arrat_filter(配列, コールバック関数 [, フラグ]);
        $project_resource_name = array_filter($project_resource_input, function($array) {
            return $array['resource_name'];
        });
        $project_resource = array_filter($project_resource_name, function($array) {
             return $array['consumption_quantity'];
        });

        $request->session()->put('project_resource_input', $project_resource);

        return redirect('/progress_plans/task_charge');
    }
}
