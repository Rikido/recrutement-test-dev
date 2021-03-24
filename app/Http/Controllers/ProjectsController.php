<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use App\Http\Requests\CreateProject;
use Validator;
use Illuminate\Support\Facades\Storage;

class ProjectsController extends Controller
{
    // ログインしているかの確認
    public function __construct(){
        $this->middleware('auth');
    }

    // projectのカラムを設定
    private $projectInput = ['project_name', 'group', 'outline'];

    // projectsの一覧取得
    public function index()
    {
        // projectsの一覧と関連したgroupsの取得
        $projects = Project::with('group')->get();

        return view('projects.index', [ 'projects' => $projects ]);
    }

    // project詳細画面の表示
    public function show($id)
    {
        $project = Project::findOrFail($id);
        return view('projects.show', [ 'project' => $project ]);
    }

    // project作成フォームの表示
    public function create()
    {
        // ログイン中のuserが所属しているgroupsを取得
        $auth_user_groups = auth()->user()->groups;

        return view('projects.create', ['auth_user_groups' => $auth_user_groups]);
    }

    // バリデーションの実行とセッションに入力値を保存
    public function createStore(CreateProject $request)
    {
        $input = $request->only($this->projectInput);
        $path = $request->file('file_path')->store('public/project_pdf');
        $request->session()->put(["projectInfo" => $input, "projectPdf" => $path]);

        return redirect()->action('ProjectsController@confirm');
    }

    // セッションから入力値を取り出し確認画面の表示
    public function confirm(Request $request)
    {
        // セッションから値を取り出す
        $input = $request->session()->get("projectInfo");
        $path = $request->session()->get("projectPdf");

        // セッションに値がない時はフォームに戻る
        if(!$input){
            return redirect()->action('ProjectsController@create');
        }

        return view('projects.confirm', compact('input', 'path'));
    }

    // セッションの値をデータベースに保存する
    public function confirmStore(Request $request)
    {
        // リクエストから値を取り出す
        $input = $request->session()->get("projectInfo");
        $path = $request->session()->get("projectPdf");

        if($request->has("back")){
            Storage::delete("$path");
            return redirect()->action("ProjectsController@create")
            ->withInput($input);
        }

        // セッションに値がない時はフォームに戻る
        if(!$input){
            return redirect()->action('ProjectsController@create');
        }

        // projectの保存処理
        $project = new Project;
        $project->project_name = $input["project_name"];
        $project->group_id = $input["group"];
        $project->outline = $input["outline"];
        $project->file_path = $path;
        $project->save();

        // セッションを空にする
        $request->session()->forget('input', 'path');

        return redirect()->action('ProjectsController@done');
    }

    // projectの保存の完了画面
    public function done()
    {
        return view('projects.doneCreate');
    }
}
