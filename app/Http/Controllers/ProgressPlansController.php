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
        //dd($resource_stocks_index);
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

        //拠点、資材、使用数を格納する配列
        $location_array = [];
        $index = 0;
        foreach((array)$large_resource_stocks_array as $large_resource_stock) {
            //利用資材入力画面で選択した資材マスタのidに一致するresource_stocksを全て取得
            //在庫数が多い順に並べ替える
            $resource_stocks = DB::table('resource_stocks')->where('resource_id', $large_resource_stock["resource_name"])->orderBy('stock', 'DESC')->get();
            foreach((array)$resource_stocks as $resource_stock_array) {
                foreach((array)$resource_stock_array as $resource_stock) {
                    $location_array[$index]["location"] = $resource_stock->location_id;
                    $location_array[$index]["resource"] = $resource_stock->resource_id;
                    //在庫より使用数の方が多い場合
                    if($resource_stock->stock < $large_resource_stock["consumption_quantity"]) {
                        //在庫を全て使用数に格納
                        $location_array[$index]["consumption_quantity"] = $resource_stock->stock;
                        //必要数から在庫分し差し引き、残りの使用数を算出する
                        $large_resource_stock["consumption_quantity"] = $large_resource_stock["consumption_quantity"] - $resource_stock->stock;
                        $index++;
                        //在庫分で使用数を満たした場合
                    } else {
                        //必要数を格納する
                        $location_array[$index]["consumption_quantity"] = (int)$large_resource_stock["consumption_quantity"];
                        $index++;
                        break;
                    }
                }
            }
        }
        //dd($large_resource_stock);
        return view('progress_plans/location', compact('project', 'resource_stocks_index', 'large_resource_stock', 'location_array'));
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
        if(!empty($request->session()->get('resource_stocks_input'))) {
            $project_resources = $request->session()->get('resource_stocks_input');
        } else {
            $project_resources = [];
        }
        //dd($task_charges);
        //使用する車両を格納する配列
        $vehicles_array = [];
        $index = 0;

        if(!empty($project_resources)) {
            foreach((array)$project_resources as $project_resource) {
                $resource_stock = ResourceStock::find($project_resource["resource_id"]);
                $resource_size = $resource_stock['size'];
                //車両を全て取得
                $vehicles_index = Vehicle::get();
                foreach((array)$vehicles_index as $vehicles) {
                    foreach((array)$vehicles as $vehicle) {
                        //使用する車両の情報を配列に格納する
                        $vehicles_array[$index]["vehicle_id"] = $vehicle["id"];
                        $vehicles_array[$index]["vehicle_weight"] = Vehicle::find($vehicle["id"]);
                        $vehicles_array[$index]["vehicle_size"] = $vehicle["max_size"];
                        //車両に搭載する資材のIDを配列に格納
                        $vehicles_array[$index]["resource_id"] = $resource_stock["resource_id"];
                        //車両に搭載する資材の名前を配列に格納
                        $vehicles_array[$index]["resource_name"] = Resource::find($resource_stock["resource_id"])["resource_name"];
                        //車両に搭載する資材の重量を配列に格納
                        $vehicles_array[$index]["resource_weight"] = $resource_stock["weight"];
                        $index++;
                        // もし車両に資材を積むことができたら
                        if(0 == $project_resource["consumption_quantity"]) {
                            //ループを抜ける
                            break;
                        }
                    }
                }
            }
        }

        //実施日を判断
        $now_date = date("Y-m-d");
        $task_charges = $request->session()->get("task_charge_input");
        //担当情報からユーザーIDを取得する
        $task_users = [];
        foreach((array)$task_charges as $task_charge) {
            array_push($task_users, $task_charge["user_id"]);
        }
        //今日以降のユーザー稼働日を昇順で全て取得する
        $already_user_work_schedule = UserWorkSchedule::whereIn('user_id', $task_users)
          ->where('work_date', '>', $now_date)
          ->orderBy('work_date', 'asc')->get()->toArray();
        //使用する車両のIDを取得する
        $select_vehicles = [];
        foreach((array)$vehicles_array as $vehicle_array) {
            array_push($select_vehicles, $vehicle_array["vehicle_id"]);
        }
        //重複するIDを削除
        $select_vehicles = collect($select_vehicles)->unique()->toArray();
        //今日以降の車両稼働日を昇順で全て取得する
        if(!empty($project_resources)) {
            $already_vehicle_work_schedule = VehicleWorkSchedule::whereIn('vehicle_id', $select_vehicles)
              ->where('work_date', '>', $now_date)
              ->orderBy('work_date', 'asc')->get()->toArray();
        } else {
            $already_vehicle_work_schedule = [];
        }
        //ユーザーも車両も予定がない場合
        if((empty($already_user_work_schedule)) && (empty($already_vehicle_work_schedule))) {
            //明日の日付を格納する
            $work_date = date('Y-m-d', strtotime('+1 day'));
            //予定がある場合の処理
        } else {
            //ユーザーの予定があるか確認
            if(!empty($already_user_work_schedule)) {
                $user_i = 1;
                $user_work_date = date("Y-m-d", strtotime("+{$user_i} day"));
                foreach((array)$already_user_work_schedule as $already_user_work) {
                    //明日の日付が既に予定にあった場合
                    if($user_work_date == $already_user_work["work_date"]) {
                        //1日後の予定を確認する
                        $user_i++;
                        $user_work_date = date("Y-m-d", strtotime("+{$user_i} day"));
                    } else {
                        //最短稼働日を取得
                        $user_work_date = $user_work_date;
                        continue;
                    }
                }
            }
            //車両の予定があるか確認
            if(!empty($already_vehicle_work_schedule)) {
                $vehicle_i = 1;
                $vehicle_work_date = date("Y-m-d", strtotime("+{$vehicle_i} day"));
                //車両の最短稼働日を取得
                foreach((array)$already_vehicle_work_schedule as $already_vehicle_work) {
                    if($vehicle_work_date == $already_vehicle_work["work_date"]) {
                        $vehicle_i++;
                        $vehicle_work_date = date("Y-m-d", strtotime("+{$vehicle_i} day"));
                    } else {
                        $vehicle_work_date = $vehicle_work_date;
                        continue;
                    }
                }
            }
            //ユーザーの予定がない場合
            if(empty($user_work_date)) {
                $work_date = $vehicle_work_date;
            } elseif (empty($vehicle_work_date)) {
                $work_date = $user_work_date;
            } else {
                //ユーザーと車両それぞれの稼働日の大きい方を取得する
                $work_date = max($user_work_date, $vehicle_work_date);
            }
        }
        $request->session()->put('vehicles_select_input', $vehicles_array);
        return view('progress_plans/work_schedule', compact('project', 'task_charges', 'project_resources', 'vehicles_array', 'work_date'));
    }

    //工事実施日程の値を保存
    public function work_scheduleStore($id, Request $request) {
        $project = Project::findOrFail($id);
        $work_date = $request->input('work_date');
        $request->session()->put('work_date_input', $work_date);
        return redirect()->action('ProgressPlansController@confirm', ['id' => $project->id]);
    }

    public function confirm($id, Request $request) {
        $project = Project::with('group.users')->find($id);
        //担当情報を取得する
        $task_charges = $request->session()->get('task_charge_input');
        //案件使用資材を取得する
        $project_resources = $request->session()->get('resource_stocks_input');
        //工事実施日を取得する
        $work_date = $request->session()->get('work_date_input');
        //dd($work_date);
        return view('progress_plans/confirm', compact('project', 'task_charges', 'project_resources', 'work_date'));
    }

    public function confirmStore($id, Request $request) {
        $project = Project::with('group.users')->find($id);
        //担当情報を取得する
        $task_charges = $request->session()->get('task_charge_input');
        //案件使用資材を取得する
        $project_resources = $request->session()->get('resource_stocks_input');
        //工事実施日を取得する
        $work_date = $request->session()->get('work_date_input');
        foreach((array)$task_charges as $task_charge_data) {
            $task_charge = new TaskCharge;
            $task_charge->project_id = $project->id;
            $task_charge->task_name = $task_charge_data["task_name"];
            $task_charge->user_id = $task_charge_data["user_id"];
            $task_charge->outline = $task_charge_data["outline"];
            $task_charge->order = $task_charge_data["order"];
            $task_charge->save();
        }

        if(!empty($project_resources)) {
            foreach((array)$project_resources as $project_resource_data) {
                $project_resource = new ProjectResource;
                $project_resource->project_id = $project->id;
                $project_resource->resource_id = $project_resource_data["resource_id"];
                $project_resource->location_id = $project_resource_data["location_id"];
                $project_resource->consumption_quantity = $project_resource_data["consumption_quantity"];
                $project_resource->save();
            }
        }

        foreach((array)$task_charges as $task_charge_data) {
            $user_work_schedule = new UserWorkSchedule;
            $user_work_schedule->project_id = $project->id;
            $user_work_schedule->user_id = $task_charge_data["user_id"];
            $user_work_schedule->work_date = $work_date;
            $user_work_schedule->save();
        }

        $request->session()->forget('project_resource_input', 'task_charge_input', 'work_date_input', 'resource_stocks_input');
        return redirect()->action('ProgressPlansController@complete', ['id' => $project->id]);
    }

    public function complete($id) {
        $project = Project::with('group.users')->find($id);
        //dd($project);
        return view('progress_plans/complete', compact('project'));
    }
}
