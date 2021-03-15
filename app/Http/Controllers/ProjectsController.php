<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Storage;

class ProjectsController extends Controller
{
    // ログインしているかの確認
    public function __construct(){
        $this->middleware('auth');
    }

    private $projectInput = ['project_name', 'group', 'outline'];

    // projectsの一覧取得
    public function index()
    {
        // projectsの一覧と関連したgroupsの取得
        $projects = Project::all();

        return view('projects.index', [ 'projects' => $projects ]);
    }

    // project作成フォームの表示
    public function create()
    {
        // ログイン中のuserが所属しているgroupsを取得
        $auth_user_groups = auth()->user()->groups;

        return view('projects.create', ['auth_user_groups' => $auth_user_groups]);
    }

    // セッションに入力値を保存
    public function createStore(Request $request)
    {
        
        // 送信された値にバリデーションを実行
        $validatedData = $request->validate([
            'project_name' => 'required|string|max:100',
            'group'        => 'required|integer',
            'outline'      => 'required|string|max:500',
            'file_path'    => 'required|mimes:pdf',
        ]);

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
        // セッションから値を取り出す
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
