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
        // セッションへデータを保存
        $request->session()->put('resource_stocks_input', $resource_stocks_input);
        // 工事実施日程の表示画面へ遷移
        return redirect()->action('ProgressPlansController@scheduled_date', ['id' => $project->id]);
    }

    // 工事実施日程の表示画面
    public function scheduled_date($id, Request $request) {
        $project = Project::findOrFail($id);
        $file_name = str_replace('public/', '', $project->file_path);
        // セッションへ保存した担当情報を取り出す
        $task_charges = $request->session()->get('task_charge_input');
        // セッションへ保存した案件使用資材を取り出す
        $project_resources = $request->session()->get('resource_stocks_input');
        return view('progress_plans.scheduled_date', compact('project', 'file_name', 'task_charges', 'project_resources'));
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
