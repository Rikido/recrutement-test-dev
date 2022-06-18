<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Project;
use App\Resource;
use App\ResourceStock;
use App\TaskCharge;
use App\User;
use App\Group;
use App\Location;
use App\ProjectResource;
use App\Vehicle;
use App\UserWorkSchedule;
use App\VehicleWorkSchedule;


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
        //空の配列を削除する
        $task_name_check = array_filter($task_charges_input, function($array){
            return $array['task_name'];
        });
        $user_id_check = array_filter($task_name_check, function($array){
            return $array['user_id'];
        });
        $outline_check = array_filter($user_id_check, function($array){
            return $array['outline'];
        });
        $task_charges = array_filter($outline_check, function($array){
            return $array['order'];
        });

        foreach($task_charges as $index => $task_charge) {
            $task_user = User::find($task_charge["user_id"]);
            // 担当するユーザーの名前を格納
            $task_charges[$index]["user_name"] = $task_user->name;
        }

        $request->session()->put('task_charge_input', $task_charges);
        $project_resources = $request->session()->get('project_resource_input');

        //dd($task_charges);

        // 利用資材入力画面で選択した資材に大型資材が含まれているか
        foreach($project_resources as $project_resource) {
            $resource_id = $project_resource["resource_name"];
            $resource = Resource::find($resource_id);
            // resource_type=true 大型
            if($resource->resource_type == true) {
                //大型資材積込み拠点選択画面へ
                //dd($task_charges);
                return redirect()->action('ProgressPlansController@location', ['id' => $project->id]);
            }
        };
        // なければ工事実施日程の表示画面へ
        return redirect()->action('ProgressPlansController@work_schedule', ['id' => $project->id]);
    }

    //大型資材積込み拠点選択
    public function location($id, Request $request) {
        $project = Project::with('group.users')->find($id);
        $resource_stocks_index = ResourceStock::all();
        $project_resources = $request->session()->get('project_resource_input');
        // 大型資材のみ格納する配列
        $large_resource_stocks_array = [];
        // 利用資材入力画面で選択した資材に大型資材が含まれているか
        foreach((array)$project_resources as $project_resource) {
            $resource_id = $project_resource["resource_name"];
            $resource = Resource::find($resource_id);
            if($resource->resource_type == true) {
                // true(大型資材)の入力値のみ配列に格納する
                array_push($large_resource_stocks_array, $project_resource);
            }
        };
        //dd($project_resource);

        //拠点、資材、使用数を格納する配列
        $location_array = [];

        $index = 0;
        foreach((array)$large_resource_stocks_array as $large_resource_stock) {
            // 利用資材入力画面で選択した資材マスタのidに一致するresource_stocksを全て取得
            //在庫数が多い順に並べ替える
            $resource_stocks = DB::table('resource_stocks')->where('resource_id', $large_resource_stock["resource_name"])->orderBy('stock', 'DESC')->get();

            foreach((array)$resource_stocks as $resource_stock_array) {
                foreach((array)$resource_stock_array as $resource_stock) {
                    $location_array[$index]["location"] = $resource_stock->location_id;
                    $location_array[$index]["resource"] = $resource_stock->resource_id;
                    // 在庫より使用数の方が多い場合
                    if($resource_stock->stock < $large_resource_stock["consumption_quantity"]) {
                        // 在庫を全て使用数に格納
                        $location_array[$index]["consumption_quantity"] = $resource_stock->stock;
                        // 必要数から在庫分し差し引き、残りの使用数を算出する
                        $large_resource_stock["consumption_quantity"] = $large_resource_stock["consumption_quantity"] - $resource_stock->stock;
                        $index++;
                        // 在庫分で使用数を満たした場合
                    } else {
                        // 必要数を格納する
                        $location_array[$index]["consumption_quantity"] = (int)$large_resource_stock["consumption_quantity"];
                        $index++;
                        break;
                    }
                }
            }
        }

        //dd($location_array);
        return view('progress_plans/location', compact('project', 'resource_stocks_index', 'large_resource_array', 'location_array'));
    }

    public function locationStore($id, Request $request) {
        $project = Project::with('group.users')->find($id);
        $resource_stocks_input = $request->input('resource_stocks');
        $resource_stocks_input = array_filter($resource_stocks_input, function($array){
            return $array['consumption_quantity'];
        });

        foreach($resource_stocks_input as $index => $resource_stock) {
            $select_location = Location::find($resource_stock["location_id"]);
            $select_resource = Resource::find($resource_stock["resource_id"]);
            // 選択した拠点の名前を取得
            $resource_stocks_input[$index]["location_name"] = $select_location->location_name;
            // 選択した資材の名前を取得
            $resource_stocks_input[$index]["resource_name"] = $select_resource->resource_name;
        }
        $request->session()->put('resource_stocks_input', $resource_stocks_input);
        // 工事実施日程の表示画面へ遷移
        return redirect()->action('ProgressPlansController@work_schedule', ['id' => $project->id]);

    }

    public function work_schedule($id, Request $request) {
        $project = Project::with('group.users')->find($id);
        $task_charges = $request->session()->get('task_charge_input');
        $project_resources = $request->session()->get('resource_stocks_input');
        //dd($task_charges);

        return view('progress_plans/work_schedule', compact('project', 'task_charges', 'project_resources'));
    }

    public function work_scheduleStore() {
        //
    }

    public function confirm() {
        //
        return view('progress_plans/confirm');
    }

    public function confirmStore() {
        //
        return redirect()->action('ProgressPlansController@complete');
    }

    public function complete() {
        //
        return view('progress_plans/complete');
    }

}
