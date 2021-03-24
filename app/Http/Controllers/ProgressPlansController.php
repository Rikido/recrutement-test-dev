<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateProjectResources;
use App\Http\Requests\CreateTaskCharges;

use App\Project;
use App\Resource;
use App\Vehicle;
use App\Resource_stock;
use App\User_work_schedule;
use App\Vehicle_work_schedule;
use App\Task_charge;
use App\Project_resource;

class ProgressPlansController extends Controller
{
    // 使用資材選択画面の表示
    public function resourceSelect($id)
    {
        // 進行プランを作成するprojectと関連の情報を取得
        $project = Project::with('group.users')->find($id);
        // システムに登録されているresourcesを取得
        $resources = Resource::all();
        // sessionにprojectの情報を保存
        session()->put('project', $project);
        // 利用資材登録画面を表示する
        return view('progress_plan.resource_select', compact('project', 'resources'));
    }

    public function taskCharges(CreateProjectResources $request)
    {
        // 入力された値を変数に保存
        $project_resources = $request->input('project_resource');
        // project_resourcesから空の配列を削除する
        foreach( (array)$project_resources as $project_resource => $project_resource_copy)
        {
            if( $project_resource_copy["resource"] == null) unset($project_resources[$project_resource]);
        };
        // セッションにproject_resourcesを保存
        $request->session()->put(["project_resources" => $project_resources]);

        // sessionからproject情報を取得する
        $project = $request->session()->get('project');
        // 担当割り当て画面の表示
        return view('progress_plan.task_charges', ['project' => $project]);
    }

    public function locationSelect(CreateTaskCharges $request){
        // $requestから入力された値を取り出す
        $task_charges = $request->input('task_charge');
        // task_chargeから空の配列を削除する
        foreach( (array)$task_charges as $task_charge => $task_charge_copy)
        {
            if( $task_charge_copy["task_name"] == null) unset($task_charges[$task_charge]);
        };
        // sessionにtask_chargesを保存する
        $request->session()->put(["task_charges" => $task_charges]);

        // sessionからproject_resourceの値を取り出す
        $project_resources = $request->session()->get("project_resources");
        // 利用資材に大型資材があった場合に保存する配列を生成
        $resource_large = array();
        // 利用資材が大型かどうか判別、大型だった場合配列に保存
        foreach( $project_resources as $index => $project_resource)
        {
            $resource = Resource::find($project_resource["resource"]);
            if($resource->resource_type) {
                array_push($resource_large, $index);
            }
        };

        // 大型資材が存在した場合大型資材積み込み拠点の入力画面へ遷移。そうじゃない場合工事実施日程の表示画面へ遷移
        if ( $resource_large != [] ) {
            // sessionに大型資材のproject_resourcesのkeyを保存
            $request->session()->put(["resource_large" => $resource_large]);
            // sessionからproject情報を取得する
            $project = $request->session()->get('project');
            // sessionからproject_resourceを取得
            $project_resources = $request->session()->get('project_resources');
            // 大型資材のresource_idを保存する配列
            $large_resource_id = array();
            // 大型資材のresource_idを配列に保存
            foreach($resource_large as $large_int)
            {
                array_push($large_resource_id, $project_resources[$large_int]["resource"]);
            };
            // resource_stockからproject_resourceを取得
            $project_resource_stocks = Resource_stock::where('resource_id', $large_resource_id)
                ->orderBy('stock', 'desc')->get();
            if($project_resource_stocks[0]->stock >= $project_resources[$large_int]["consumption_quantity"])
            {
                $system_suggest_load = $project_resources[$large_int]["consumption_quantity"];
            } else {
                $system_suggest_load = $project_resources[0]->stock;
            };
            $request->session()->put(["project_resource_stocks" => $project_resource_stocks[0]]);
            return view('progress_plan.location_select', compact('project', 'project_resource_stocks', 'system_suggest_load'));
        } else {
            // sessionからproject情報を取得する
            $project = $request->session()->get('project');
            return redirect()->route('progress_plan.work_schedule', ['id' => $project->id]);
        }
    }

    public function vehicleSelect(Request $request)
    {
        // requestから入力された値を取り出す
        $consumption_quantity = $request->input('consumption_quantity');
        // sessionに入力された値を保存
        $request->session()->put(["consumption_quantity" => $consumption_quantity]);
        // sessionからproject情報を取得する
        $project = $request->session()->get('project');
        // projectで使用するresource_stockの取得
        $project_resource_stocks = $request->session()->get("project_resource_stocks");
        // projectで使用するresourceを積み込める車両の取得
        $vehicles = Vehicle::where('max_size', '>=', $project_resource_stocks["size"])->get();
        return view('progress_plan.vehicle_select', compact('vehicles', 'project'));
    }

    public function workSchedule(Request $request)
    {
        // sessionからproject情報を取得する
        $project = $request->session()->get('project');
        // sessionからtask_charges情報を取得する
        $task_charges = $request->session()->get('task_charges');
        // projectで使用するresource_stockの取得
        $project_resource_stocks = $request->session()->get("project_resource_stocks");
        // projectで使用するconsumption_quantityの取得
        $consumption_quantity = $request->session()->get("consumption_quantity");
        // $requestから入力したvehicle_idの取得
        $vehicle_id = $request->input('vehicle');
        // sessionにvehicle_idを保存
        $request->session()->put(["vehicle_id" => $vehicle_id]);
        // sessionから担当割当情報を取得
        $task_charges = $request->session()->get("task_charges");
        $task_charge_users = array();
        foreach((array)$task_charges as $task_charge)
        {
            array_push($task_charge_users, $task_charge["user"]);
        };
        $now_date = date("Y-m-d");
        $user_work_schedules = User_work_schedule::where('user_id', $task_charge_users)
            ->where('work_date', '>', $now_date)
            ->orderBy('work_date')->get()->toArray();
        $vehicle_work_schedules = Vehicle_work_schedule::where('vehicle_id', $vehicle_id)
            ->where('work_date', '>', $now_date)
            ->orderBy('work_date')->get()->toArray();

        if(empty($user_work_schedules)){
            $work_date = date('Y-m-d', strtotime('+1 day'));
        } else {
            $i = 1;
            while(true){
                $work_date = date('Y-m-d', strtotime("+2 day"));
                $search_user_work = array_search( $work_date, array_column( $user_work_schedules, 'work_date'));
                if(!$search_user_work){
                    $search_vehicle_work = array_search( $work_date, array_column( $vehicle_work_schedules, 'work_date'));
                    if(!$search_vehicle_work){
                        break;
                    }
                }
                $search_user_work = null;
                $search_vehicle_work = null;
                $i += 1; 
            }
        }

        return view('progress_plan.work_date', compact('project', 'task_charges', 'project_resource_stocks', 'consumption_quantity', 'work_date'));
    }

    public function confirm(Request $request)
    {
        // $requestから送られてきたwork_dateを取得
        $work_date = $request->input('work_date');
        // $work_dateをsessionに保存
        $request->session()->put(['work_date' => $work_date]);
        // sessionからproject情報を取得する
        $project = $request->session()->get('project');
        // sessionからtask_charges情報を取得する
        $task_charges = $request->session()->get('task_charges');
        // projectで使用するresource_stockの取得
        $project_resource_stocks = $request->session()->get("project_resource_stocks");
        // projectで使用するconsumption_quantityの取得
        $consumption_quantity = $request->session()->get("consumption_quantity");
        return view('progress_plan.confirm', compact('project', 'task_charges', 'project_resource_stocks', 'consumption_quantity', 'work_date'));
    }

    public function store(Request $request)
    {
        // sessionからproject情報を取得する
        $project = $request->session()->get('project');
        // sessionからproject_resources情報を取得する
        $project_resources = $request->session()->get('project_resources');
        // sessionからtask_charges情報を取得する
        $task_charges = $request->session()->get('task_charges');
        // sessionからvehicle情報を取得する
        $vehicle_id = $request->session()->get('vehicle_id');
        // sessionからwork_date情報を取得する
        $work_date = $request->session()->get('work_date');
        // sessionからconsumption_quantity情報を取得する
        $consumption_quantity = $request->session()->get('consumption_quantity');
        // sessionからresource_large情報を取得する
        $resource_large = $request->session()->get('resource_large');
        // sessionからproject_resource_stocks情報を取得する
        $project_resource_stocks = $request->session()->get('project_resource_stocks');
        
        foreach($project_resources as $index => $project_resource_info){
            $project_resource = new Project_resource;
            $project_resource->project_id = $project->id;
            $project_resource->resource_id = $project_resource_info["resource"];
            $project_resource->consumption_quantity = $project_resource_info["consumption_quantity"];
            if(in_array($index, $resource_large)){
                $project_resource->location_id = $project_resource_stocks->location_id;
                $project_resource->consumption_quantity = $consumption_quantity;
            }
            $project_resource->save();
        }

        foreach($task_charges as $task_charge_info){
            $task_charge = new Task_charge;
            $task_charge->project_id = $project->id;
            $task_charge->task_name = $task_charge_info["task_name"];
            $task_charge->user_id = $task_charge_info["user"];
            $task_charge->outline = $task_charge_info["outline"];
            $task_charge->order = $task_charge_info["order"];
            $task_charge->save();

            $user_work_date = new User_work_schedule;
            $user_work_date->project_id = $project->id;
            $user_work_date->user_id = $task_charge_info["user"];
            $user_work_date->work_date = $work_date;
            $user_work_date->save();
        }

        $vehicle_work_schedules = new Vehicle_work_schedule;
        $vehicle_work_schedules->project_id = $project->id;
        $vehicle_work_schedules->user_id = auth()->user()->id;
        $vehicle_work_schedules->vehicle_id = $vehicle_id;
        $vehicle_work_schedules->work_date = $work_date;
        $vehicle_work_schedules->save();

        // 削除 (全データ)
        session()->flush();

        return view('progress_plan.complete');
    }
}
