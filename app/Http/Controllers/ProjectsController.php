<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectsController extends Controller
{
    //ログイン認証
    public function __construct(){
        $this->middleware('auth');
    }

    private $projectInput = ['project_name', 'group_id', 'outline'];

    //案件一覧
    public function index()
    {
        $projects = Project::with('group')->get();

        return view('projects/index', [ 'projects' => $projects ]);
    }

    //案件登録
    public function create() {
        //ログインユーザーが所属しているgroup
        $auth_user_groups = auth()->user()->groups;

        /*foreach($auth_user_groups as $auth_user_group){
            var_dump($auth_user_group->group_name);
        }
        exit;
        dd($auth_user_groups[0]->group_name);*/
        return view('projects/create', compact('auth_user_groups'));
    }

    //案件登録の値を保存
    public function store(Request $request) {
        //入力データ取得
        $input = $request->only($this->projectInput);
        $path = $request->file('file_path')->store('public/project_pdf');
        $request->session()->put(["project_input" => $input, "projectPdf" => $path]);

        return redirect('/projects/confirm');
    }

    //案件詳細
    public function show($id) {

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
