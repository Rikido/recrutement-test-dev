<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Project;
use App\Resource;
use App\ResourceStock;
use App\TaskCharge;
use App\User;
use App\Group;
use App\Location;
use App\ProjectResource;


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
        //array_filter(配列, コールバック関数 [, フラグ]);
        $project_resource_name = array_filter($project_resource_input, function($array) {
            return $array['resource_name'];
        });
        $project_resource = array_filter($project_resource_name, function($array) {
             return $array['consumption_quantity'];
        });

        $request->session()->put('project_resource_input', $project_resource);
        //dd($project_resource);

        return redirect()->action('ProgressPlansController@task_charge', ['id' => $project->id]);
    }

    //担当割当
    public function task_charge($id) {
        $project = Project::with('group.users')->find($id);
        return view('progress_plans/task_charge', compact('project'));
    }

    //担当割当の値を保存
    public function task_chargeStore($id, Request $request) {
        $project = Project::with('group.users')->find($id);
        $task_charges_input = $request->input('task_charges');
        // task_chargeから空の配列を削除する
        //foreach内でunsetを使って特定の要素を削除する
        foreach( (array)$task_charges_input as $task_charge => $task_charge_copy)
        {
            if( $task_charge_copy["task_name"] == null) unset($task_charge[$task_charge]);
        }

        $project_resources = $request->session()->get('project_resource_input');

        // 利用資材入力画面で選択した資材に大型資材が含まれているか
        foreach($project_resources as $project_resource) {
            $resource_id = $project_resource["resource_name"];
            $resource = Resource::find($resource_id);
            // resource_type=true 大型
            if($resource->resource_type == true) {
                //大型資材積込み拠点選択画面へ
                return redirect()->action('ProgressPlansController@location', ['id' => $project->id]);
            }
        };
        // なければ工事実施日程の表示画面へ
        return redirect()->action('ProgressPlansController@work_schedule', ['id' => $project->id]);
    }

    //大型資材積込み拠点選択
    public function location($id, Request $request) {
        $project = Project::with('group.users')->find($id);
        $project_resources = $request->session()->get('project_resource_input');
        $resource_stocks_index = ResourceStock::all();
        $large_resource = [];
        // 利用資材入力画面で選択した資材に大型資材が含まれているか
        foreach((array)$project_resources as $project_resource) {
            $resource_id = $project_resource["resource_name"];
            $resource = Resource::find($resource_id);
            if($resource->resource_type == true) {
                // true(大型資材)の入力値のみ配列に格納する
                array_push($large_resource, $project_resource);
            }
        };
        return view('progress_plans/location');
    }

    public function work_schedule($id, Request $request) {
        //
        return view('progress_plans/work_schedule');
    }

}
