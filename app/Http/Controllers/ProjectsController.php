<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use Illuminate\Support\Facades\Auth;

class ProjectsController extends Controller
{
    // ログインしていない場合はログインページへ移動
    public function __construct(){
        $this->middleware('auth');
    }

    // 登録データ([フォーム名])
    private $projectContents = ['project_name', 'group_id', 'outline'];

    // バリデーション情報
    private $validator = [
        // requiredで入力必須
        'project_name' => 'required|string|max:100',
        'group_id' => 'required|integer',
        'outline' => 'required|string|max:255',
        // mimesでファイルが指定された拡張子かどうか判定する
        'file_path' => 'required|file|mimes:pdf',
    ];

    // 案件一覧画面
    public function index()
    {
        $projects = Project::with('group')->get();
        $auths = Auth::user();
        return view('projects.index', compact('projects', 'auths'));
    }

    // 案件登録画面
    public function create()
    {
        // ログインユーザーが所属しているgroupを全て取得
        $auth_user_groups = auth()->user()->groups;
        return view('projects.create', compact('auth_user_groups'));
    }

    // 案件登録画面の入力値をセッションに登録する処理
    public function post(Request $request)
    {
        // 入力データの取得
        $input = $request->only($this->projectContents);
        // リクエスト中にファイルが存在しているかを判定
        if ($request->hasFile('file_path')) {
            // pdfファイル名の取得
            $file_name = $request->file('file_path')->getClientOriginalName();
            // pdfアップロードファイルの取得->storeAsメソッドの第一引数に保存先、第二引数に保存時のファイル名を渡す
            $file = $request->file('file_path')->storeAs('public', $file_name);
        }
        // バリデータの生成（第１引数にバリデーションを行うデータ、第２引数にそのデータに適用するバリデーションルール）
        $validator = validator($request->all(), $this->validator);
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
        $request->session()->put(['project_input' => $input, 'project_file' => $file, 'file_name' => $file_name]);
        // 作成案件確認画面に遷移
        return redirect()->action('ProjectsController@comfirm');
    }

    // 作成案件確認画面
    public function comfirm(Request $request)
    {
        // セッションから値を取り出す
        $input = $request->session()->get('project_input');
        $file = $request->session()->get('project_file');
        $file_name = $request->session()->get('file_name');
        // セッションに値が無い時はフォームに戻る
        if(!$input){
            return redirect()->action('ProjectsController@create');
        }
        return view('projects.comfirm', compact('input', 'file', 'file_name'));
    }

    // セッションから入力値を取り出し、DBに登録後、セッションの入力値を削除する処理
    public function register(Request $request)
    {
        $input = $request->session()->get('project_input');
        $file = $request->session()->get('project_file');

        if(!$input){
            return redirect()->action('ProjectsController@create');
        }
        // projectの登録処理
        $project = new Project;
        $project->project_name = $input['project_name'];
        $project->group_id = $input['group_id'];
        $project->outline = $input['outline'];
        $project->file_path = $file;
        $project->save();
        // セッションを空にする、セッションから値を削除するときはforget()関数を使用
        $request->session()->forget('project_input', 'project_file', 'file_name');

        return redirect()->action('ProjectsController@complete');
    }

    // 案件作成完了画面
    public function complete()
    {
        return view('projects.complete');
    }

    // 進行プラン詳細画面
    public function show($id)
    {
        // 該当するレコードが見つからなかった場合は例外を投げ、キャッチできなければ404レスポンス
        $project = Project::findOrFail($id);
        // 文字列からpublic/を削除し、ファイル名を取得
        $file_name = str_replace('public/', '', $project->file_path);
        $auths = Auth::user();
        // URL直打ち対策
        foreach($auths->groups as $auth_group) {
            // projectの担当groupのidとログインユーザーが所属しているgroupのidを比較する
            if($auth_group->id === $project->group->id) {
                // 一致すれば案件詳細画面へ
                return view('projects.show', compact('project', 'file_name'));
            }
        }
        // 一致しなければ案件一覧画面へリダイレクト
        return redirect()->action('ProjectsController@index');
    }
}
