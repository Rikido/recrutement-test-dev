<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
// Validatorファザードの使用
use Validator;

class ProjectsController extends Controller
{
    // ログインしていない場合はログインページへ移動
    public function __construct(){
        $this->middleware('auth');
    }

    // 登録データ([フォーム名])
    private $projectContents = ['project_name', 'group_id', 'outline', 'file_path'];

    // バリデーション情報
    private $validator = [
        // requiredで入力必須
        'project_name' => 'required|string|max:100',
        'group_id' => 'required|integer',
        'outline' => 'required|string|max:255',
        // mimesでファイルが指定された拡張子かどうか判定する
        'file_path' => 'required|file|mimes:pdf',
    ];

    public function index()
    {
        $projects = Project::all();

        return view('projects.index');
    }

    public function create()
    {
        // ログインユーザーが所属しているgroupを全て取得
        $auth_user_groups = auth()->user()->groups;

        return view('projects.create', ['auth_user_groups' => $auth_user_groups]);
    }

    public function post(Request $request)
    {
        // 入力データの取得
        $input = $request->only($this->projectContents);
        // バリデータの生成（makeメソッドの第１引数にバリデーションを行うデータ、第２引数にそのデータに適用するバリデーションルール）
        $validator = Validator::make($input, $this->validator);
        // エラー時の処理
        if($validator->fails()){
            // 案件作成画面にリダイレクト
            return redirect()->action('ProjectsController@create')
            // セッション(_old_input)に入力値を全て格納
            ->withInput()
            // セッション(errors)にエラーの情報を格納
            ->withErrors($validator);
        }
        // セッションへデータを保存
        $request->session()->put('project_input', $input);
        // 作成案件確認画面に遷移
        return redirect()->action('ProjectsController@confirm');
    }

    public function comfirm(Request $request)
    {
        // セッションから値を取り出す
        $input = $request->session()->get('project_input');
        // セッションに値が無い時はフォームに戻る
        if(!$input){
            return redirect()->action('ProjectsController@create');
        }
        return view('projects.confirm',['input' => $input]);
    }

    public function register(Request $request)
    {
        $input = $request->session()->get('project_input');

        if(!$input){
            return redirect()->action('ProjectsController@create');
        }
        // projectの登録処理
        $project = new Project;
        $project->project_name = $input['project_name'];
        $project->group_id = $input['group_id'];
        $project->outline = $input['outline'];
        $project->file_path = $input['file_path'];
        $project->save();
        // セッションを空にする、セッションから値を削除するときはforget()関数を使用
        $request->session()->forget('project_input');

        return redirect()->action('ProjectsController@complete');
    }

    public function complete()
    {
        return view('projects.complete');
    }

    public function show()
    {

        return view('projects.show');
    }
}
