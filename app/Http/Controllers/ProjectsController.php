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
        //データ取得
        $input = $request->only($this->projectInput);
        $project = new Project();
        $project->project_name = $input["project_name"];
        $project->group_id= $input["group_id"];
        $project->outline = $input["outline"];
        $project->file_path = "";
        $project->save();

        return redirect()->action('ProjectsController@confirm');

    }

    //案件詳細
    public function show($id) {
        return view('projects/show', compact('project'));
    }

    //作成案件確認
    public function confirm(Request $request) {

        return view('projects/confirm');
    }

    //案件作成完了
    public function complete() {
        return view('projects/complete');
    }
}
