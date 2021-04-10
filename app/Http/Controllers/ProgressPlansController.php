<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Project;
use App\Resource;
use App\ResourceStock;
use App\TaskCharge;
use App\User;
use App\Group;

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
//         dd($project_resource_input);

        // 多次元配列$project_resource_inputから空の配列を削除する
        // array_filterの第一引数にコールバック関数に渡す配列を指定、第二引数にコールバック関数を指定
        // 戻り値には、コールバック関数でフィルタリングされた結果の配列を返す
        $project_resource_name = array_filter($project_resource_input, function($array){
            // $project_resource_input内の各配列のresource_nameのnullを確認
            return $array['resource_name'];
        });
//         dd($project_resource_name);
        $project_resource = array_filter($project_resource_name, function($array){
            // $project_resource_input内の各配列のconsumption_quantityのnullを確認
            return $array['consumption_quantity'];
        });
//         dd($project_resource);

        // セッションへデータを保存
        $request->session()->put(['project' => $project, 'project_resource_input' => $project_resource]);
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
//         dd($task_charges);
        // セッションへデータを保存
        $request->session()->put('task_charge_input', $task_charges);
        // 利用資材入力画面でセッションに保存した値を取り出す
        $project_resources = $request->session()->get('project_resource_input');
//         dd($project_resources);
        // 利用資材入力画面で選択した資材に大型資材が含まれているか確認
        foreach( $project_resources as $key => $project_resource)
        {
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
    public function location($id) {
        $project = Project::findOrFail($id);
        return view('progress_plans.location', compact('project'));
    }

    // 工事実施日程の表示画面
    public function scheduled_date($id) {
        $project = Project::findOrFail($id);
        return view('progress_plans.scheduled_date', compact('project'));
    }
}
