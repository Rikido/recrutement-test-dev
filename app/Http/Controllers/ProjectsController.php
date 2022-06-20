<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use Illuminate\Support\Facades\Auth;
class ProjectsController extends Controller

{
    //ログイン認証
    public function __construct(){
        $this->middleware('auth');
    }

    private $projectInput = ['project_name', 'group_id', 'outline'];
    //バリデーション
    private $validator = [
        'project_name' => 'required',
        'group_id' => 'required',
        'outline' => 'required',
        'file_path' => 'required',
    ];

    //案件一覧
    public function index()
    {
        $projects = Project::with('group')->get();
        $auths = Auth::user();
        return view('projects/index', compact('projects', 'auths'));
    }

    //案件登録
    public function create() {
        //ログインユーザーが所属しているgroup
        $auth_user_groups = auth()->user()->groups;

        return view('projects/create', compact('auth_user_groups'));
    }

    //案件登録の値を保存
    public function store(Request $request) {
        //入力データ取得
        $input = $request->only($this->projectInput);
        //バリデーションの実行
        $validator = validator($request->all(), $this->validator);
        if($validator->fails()){
            // 案件作成画面にリダイレクト
            return redirect()->action('ProjectsController@create')
            // セッション(errors)にエラーの情報を格納
            ->withErrors($validator);
        }

        $path = $request->file('file_path')->store('public/project_pdf');
        $request->session()->put(["project_input" => $input, "projectPdf" => $path]);

        return redirect('/projects/confirm');
    }

    //案件詳細
    public function show($id) {
        $project = Project::with('task_charges', 'project_resources')->find($id);
        return view('projects/show', compact('project'));
    }

    //作成案件確認
    public function confirm(Request $request) {
        // セッションから値を取り出す
        $input = $request->session()->get('project_input');
        $path = $request->session()->get("projectPdf");

        return view('projects/confirm', compact('input', 'path'));
    }

    public function confirmStore(Request $request) {
        //リクエストから値を取り出す
        $input = $request->session()->get("project_input");
        $path = $request->session()->get("projectPdf");

        if ($request->get('back')) {
            return redirect('/projects/create');
        }

        //データ保存
        $project = new Project;
        $project->project_name = $input["project_name"];
        $project->group_id= $input["group_id"];
        $project->outline = $input["outline"];
        $project->file_path = $path;
        $project->save();
        // セッションを空にする
        $request->session()->forget('input', 'path');
        return redirect('/projects/complete');
    }

    //案件作成完了
    public function complete() {
        return view('projects/complete');
    }
}
