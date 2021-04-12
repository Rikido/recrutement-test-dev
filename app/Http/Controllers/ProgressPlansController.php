<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;
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
    public function __construct(){
        $this->middleware('auth');
    }

    // 利用資材入力画面
    public function resource($id) {
        $project = Project::findOrFail($id);
        $auths = Auth::user();
        $file_name = str_replace('public/', '', $project->file_path);
        // 資材マスタを全て取得する
        $resources = Resource::all();
        return view('progress_plans.resource', compact('project', 'file_name', 'auths', 'resources'));
    }

    // 利用資材入力画面の入力値をセッションに登録する処理
    public  function resource_post($id, Request $request) {
        $project = Project::findOrFail($id);
        // 入力値の取得
        $project_resource_input = $request->input('project_resources');
        // 多次元配列$project_resource_inputから空の配列を削除する
        // array_filterの第一引数にコールバック関数に渡す配列を指定、第二引数にコールバック関数を指定
        // 戻り値には、コールバック関数でフィルタリングされた結果の配列を返す
        $project_resource_name = array_filter($project_resource_input, function($array){
            // $project_resource_input内の各配列のresource_nameのnullを確認
            return $array['resource_name'];
        });
        $project_resource = array_filter($project_resource_name, function($array){
            // $project_resource_input内の各配列のconsumption_quantityのnullを確認
            return $array['consumption_quantity'];
        });
        // セッションへデータを保存
        $request->session()->put('project_resource_input', $project_resource);
        // 担当割当画面に遷移
        return redirect()->action('ProgressPlansController@task_charge', ['id' => $project->id]);
    }

    // 設計書PDFデータのダウンロード
    public function download($id) {
        $project = Project::findOrFail($id);
        $auths = Auth::user();
        // pdfファイル名取得
        $file_name = str_replace('public/', '', $project->file_path);
        // storage_pathでstorageディレクトリのフルパスを取得し、pdfファイルのパスを生成
        // /var/www/lamp/storage/app/public/pdfファイル名
        $file_path = storage_path("/app/public/$file_name");
        // ダウンロードはグループに所属するユーザーのみ可能
        foreach($auths->groups as $auth_group) {
            if($auth_group->id === $project->group->id) {
                // 一致すればファイルダウンロード
                return response()->download($file_path, $file_name);
            }
        }
        // 一致しなければ利用資材入力画面へリダイレクト
        return redirect()->action('ProgressPlansController@resource', ['id' => $project->id]);
    }

    // 担当割当画面
    public function task_charge($id) {
        $project = Project::findOrFail($id);
        $file_name = str_replace('public/', '', $project->file_path);
        return view('progress_plans.task_charge', compact('project', 'file_name'));
    }

    // 担当割当画面の入力値をセッションに登録する処理
    public function task_charge_post($id, Request $request) {
        $project = Project::findOrFail($id);
        $task_charges_input = $request->input('task_charges');
        // 空の配列の削除
        $task_name_check = array_filter($task_charges_input, function($array){ return $array['task_name']; });
        $user_id_check = array_filter($task_name_check, function($array){ return $array['user_id']; });
        $outline_check = array_filter($user_id_check, function($array){ return $array['outline']; });
        $task_charges = array_filter($outline_check, function($array){ return $array['order']; });

        foreach($task_charges as $index => $task_charge) {
            // 担当するユーザーのレコードを取得
            $task_user = User::find($task_charge["user_id"]);
            // 担当するユーザーの名前を格納
            $task_charges[$index]["user_name"] = $task_user->name;
        }
        // セッションへデータを保存
        $request->session()->put('task_charge_input', $task_charges);
        // 利用資材入力画面でセッションに保存した値を取り出す
        $project_resources = $request->session()->get('project_resource_input');
        // 利用資材入力画面で選択した資材に大型資材が含まれているか確認
        foreach($project_resources as $key => $project_resource) {
            // project_resourcesのresource_idを取得
            $resource_id = $project_resource["resource_name"];
            // 資材マスタデータの取得
            $resource = Resource::find($resource_id);
            // 資材マスタデータのresource_typeを確認
            if($resource->resource_type == true) {
                // true(大型資材)があれば大型資材積込み拠点選択画面へ遷移
                return redirect()->action('ProgressPlansController@location', ['id' => $project->id]);
            }
        };
        // なければ工事実施日程の表示画面へ遷移
        // 大型資材積込み拠点選択画面で入力した値がセッションに残っていれば削除する
        if(!empty($request->session()->get('resource_stocks_input'))) {
            $request->session()->forget('resource_stocks_input');
        }
        return redirect()->action('ProgressPlansController@scheduled_date', ['id' => $project->id]);
    }

    // 大型資材積込み拠点選択画面
    public function location($id, Request $request) {
        $project = Project::findOrFail($id);
        // 大型資材在庫を全て取得する
        $resource_stocks_index = ResourceStock::all();
        // 利用資材入力画面でセッションに保存した値を取り出す
        $project_resources = $request->session()->get('project_resource_input');
        // 利用資材入力画面で選択したデータのうち、大型資材のみ抽出して格納する配列
        $large_resource_stocks_array = [];
        // 利用資材入力画面で選択した資材に大型資材が含まれているか確認
        foreach((array)$project_resources as $key => $project_resource) {
            $resource_id = $project_resource["resource_name"];
            $resource = Resource::find($resource_id);
            if($resource->resource_type == true) {
                // true(大型資材)の入力値のみ配列に格納する
                array_push($large_resource_stocks_array, $project_resource);
            }
        };
        // [["location" => ID, "resource" => ID, "consumption_quantity" => 使用数], [], []...]の形式で値を格納
        $location_select_array = [];
        $index = 0;
        foreach((array)$large_resource_stocks_array as $key => $large_resource_stock) {
            // 利用資材入力画面で選択された資材マスタのidに一致するresource_stocksを全て取得し、在庫数が多い順に並べ替える
            $resource_stocks = DB::table('resource_stocks')->where('resource_id', $large_resource_stock["resource_name"])->orderBy('stock', 'DESC')->get();
            // resource_stocksをeach(連想配列の連想配列)
            foreach((array)$resource_stocks as $key => $resource_stock_array) {
                foreach((array)$resource_stock_array as $key => $resource_stock) {
                    // 拠点IDを追加
                    $location_select_array[$index]["location"] = $resource_stock->location_id;
                    // 資材IDを追加
                    $location_select_array[$index]["resource"] = $resource_stock->resource_id;
                    // もし在庫より使用数の方が多い場合
                    if($resource_stock->stock < $large_resource_stock["consumption_quantity"]) {
                        // 在庫を全て使用数に格納
                        $location_select_array[$index]["consumption_quantity"] = $resource_stock->stock;
                        // 必要数から在庫分し差し引き、残りの使用数を算出する
                        $large_resource_stock["consumption_quantity"] = $large_resource_stock["consumption_quantity"] - $resource_stock->stock;
                        // インクリメント
                        $index++;
                    // 在庫分で使用数を満たした場合
                    } else {
                        // 必要数を格納する(入力値はstringなのでintegerにキャスト)
                        $location_select_array[$index]["consumption_quantity"] = (int)$large_resource_stock["consumption_quantity"];
                        $index++;
                        // breakで外側のループもまとめてスキップ
                        break;
                    }
                }
            }
        }
        return view('progress_plans.location', compact('project', 'resource_stocks_index', 'large_resource_array', 'location_select_array'));
    }

    // 大型資材積込み拠点選択画面の入力値をセッションに登録する処理
    public function location_post($id, Request $request) {
        $project = Project::findOrFail($id);
        // 入力値を取得
        $resource_stocks_input = $request->input('resource_stocks');
        // consumption_quantityが空の配列を取り除く
        $resource_stocks_input = array_filter($resource_stocks_input, function($array){ return $array['consumption_quantity']; });

        foreach($resource_stocks_input as $index => $resource_stock) {
            // 選択した拠点のレコードを取得
            $select_location = Location::find($resource_stock["location_id"]);
            // 選択した資材のレコードを取得
            $select_resource = Resource::find($resource_stock["resource_id"]);
            // 選択した拠点の名前を取得
            $resource_stocks_input[$index]["location_name"] = $select_location->location_name;
            // 選択した資材の名前を取得
            $resource_stocks_input[$index]["resource_name"] = $select_resource->resource_name;
        }
        // セッションへデータを保存
        $request->session()->put('resource_stocks_input', $resource_stocks_input);
        // 工事実施日程の表示画面へ遷移
        return redirect()->action('ProgressPlansController@scheduled_date', ['id' => $project->id]);
    }

    // 工事実施日程の表示画面（使用する車両を判断し、セッションへ保存する）
    public function scheduled_date($id, Request $request) {
        $project = Project::findOrFail($id);
        $file_name = str_replace('public/', '', $project->file_path);
        // セッションへ保存した担当情報を取り出す
        $task_charges = $request->session()->get('task_charge_input');
        // 案件使用資材が空ではない場合
        if(!empty($request->session()->get('resource_stocks_input'))) {
            // セッションへ保存した案件使用資材を取り出す
            $project_resources = $request->session()->get('resource_stocks_input');
        } else {
            $project_resources = [];
        }

        // 車両の選定
        // 使用する車両を格納する配列
        $vehicles_select_array = [];
        $index = 0;
        if(!empty($project_resources)) {
            foreach((array)$project_resources as $key => $project_resource) {
                // セッションから取り出した案件使用資材のresource_idからresource_stocksを取得する(複数あるが、weightとsizeはどれも同じ)
                $resource_stock = ResourceStock::find($project_resource["resource_id"]);
                // 大型資材のサイズを取得する
                $resource_size = $resource_stock["size"];
                // 大型資材のサイズ以上の積載サイズ上限を持つ車両を全て取得する
                $vehicles_index = Vehicle::where("max_size", ">=", $resource_size)->get();
                // 連想配列の連想配列
                foreach((array)$vehicles_index as $vehicles) {
                    // $vehiclesの連想配列から出たらもう一度車両の重量を更新する
                    if(!empty($vehicles_select_array)) {
                        // 車両一覧をeach
                        foreach((array)$vehicles as $key => $vehicle) {
                            // 使用する車両をeach
                            foreach((array)$vehicles_select_array as $i => $vehicles_select) {
                                // 一覧の車両IDと使用する車両IDが一致する場合
                                if($vehicle["id"] == $vehicles_select["vehicle_id"]) {
                                    // 車両重量から搭載する資材 * 使用数を差し引く
                                    $vehicle["max_weight"] = $vehicle["max_weight"] - ($vehicles_select_array[$i]["resource_weight"] * (float)$vehicles_select_array[$i]["resource_count"]);
                                }
                            }
                        }
                    }
                    foreach((array)$vehicles as $key => $vehicle) {
                        // 使用する車両の情報を配列に格納する
                        $vehicles_select_array[$index]["vehicle_id"] = $vehicle["id"];
                        $vehicles_select_array[$index]["vehicle_weight"] = Vehicle::find($vehicle["id"])["max_weight"]; // 重量は更新されるので直接取得
                        $vehicles_select_array[$index]["vehicle_size"] = $vehicle["max_size"];
                        // 車両の最大積載量/大型資材の重量を切り捨て = 車両に積める資材の個数
                        $resource_count_float = $vehicle["max_weight"] / $resource_stock["weight"];
                        // 小数点切り捨て
                        $resource_count = (int)floor($resource_count_float);
                        // 使用数 - 車両搭載可能数が0以下の場合
                        if(0 >= ((int)$project_resource["consumption_quantity"] - (int)$resource_count)) {
                            // 使用数を格納する
                            $vehicles_select_array[$index]["resource_count"] = (int)$project_resource["consumption_quantity"];
                        } else {
                            // 車両搭載可能数を格納する
                            $vehicles_select_array[$index]["resource_count"] = $resource_count;
                        }
                        // 車両に搭載する資材のIDを配列に格納
                        $vehicles_select_array[$index]["resource_id"] = $resource_stock["resource_id"];
                        // 車両に搭載する資材の名前を配列に格納
                        $vehicles_select_array[$index]["resource_name"] = Resource::find($resource_stock["resource_id"])["resource_name"];
                        // 車両に搭載する資材の重量を配列に格納
                        $vehicles_select_array[$index]["resource_weight"] = $resource_stock["weight"];
                        // 案件で使用する資材の数量 - 車両に積める資材の個数
                        $project_resource["consumption_quantity"] = (int)$project_resource["consumption_quantity"] - (int)$vehicles_select_array[$index]["resource_count"];
                        // 車両の重量を更新
                        $vehicle["max_weight"] = $vehicle["max_weight"] - ($vehicles_select_array[$index]["resource_weight"] * (float)$vehicles_select_array[$index]["resource_count"]);
                        // インクリメント
                        $index++;
                        // もし車両に資材を積むことができたら
                        if(0 == $project_resource["consumption_quantity"]) {
                            // 外側のループを抜ける
                            break;
                        }
                    }
                }
            }
        }

        // 実施日を判断する処理
        // 今日の年月日を取得する
        $now_date = date("Y-m-d");
        // セッションから担当情報を取得する
        $task_charges = $request->session()->get("task_charge_input");
        // 担当情報からユーザーIDを取得する
        $task_users = [];
        foreach((array)$task_charges as $task_charge) {
            array_push($task_users, $task_charge["user_id"]);
        }
        // ユーザーが持つ、今日以降のユーザー稼働日を昇順で全て取得する
        $already_user_work_schedule = UserWorkSchedule::where('user_id', $task_users)->where('work_date', '>', $now_date)->orderBy('work_date', 'asc')->get()->toArray();
        // 使用する車両のIDを取得する
        $select_vehicles = [];
        foreach((array)$vehicles_select_array as $vehicle_array) {
            array_push($select_vehicles, $vehicle_array["vehicle_id"]);
        }
        // 重複するIDを削除
        $select_vehicles = collect($select_vehicles)->unique()->toArray();
        // 車両が持つ、今日以降の車両稼働日を昇順で全て取得する
        $already_vehicle_work_schedule = VehicleWorkSchedule::where('vehicle_id', $select_vehicles)->where('work_date', '>', $now_date)->orderBy('work_date', 'asc')->get()->toArray();
        // ユーザーも車両も予定がない場合
        if((empty($already_user_work_schedule)) && (empty($already_vehicle_work_schedule))) {
            // 明日の日付を格納する
            $implementation_date = date('Y-m-d', strtotime('+1 day'));
        } else {
            // 予定がある場合の処理
            $implementation_date = date('Y-m-d', strtotime('+1 day'));
        }

        // セッションへデータを保存
        $request->session()->put('vehicles_select_input', $vehicles_select_array);
        return view('progress_plans.scheduled_date', compact('project', 'file_name', 'task_charges', 'project_resources', 'vehicles_select_array', 'implementation_date'));
    }

    // 工事実施日程をセッションに登録する処理
    public function scheduled_date_post($id) {
        $project = Project::findOrFail($id);
        // 作成進行プラン内容確認画面へ遷移
        return redirect()->action('ProgressPlansController@comfirm', ['id' => $project->id]);
    }

    // 作成進行プラン内容確認画面
    public function comfirm($id) {
        $project = Project::findOrFail($id);
        return view('progress_plans.comfirm', compact('project'));
    }
}