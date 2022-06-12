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

    //案件一覧
    public function index()
    {
        $projects = Project::with('group')->get();
        return view('projects.index', [ 'projects' => $projects ]);
    }

    //案件登録
    public function create() {
        //
    }

    //案件登録の値を保存
    public function store(Request $request) {
        //
    }

    //案件詳細
    public function show($id) {
        //
    }

    //作成案件確認
    public function confirm() {
        //
    }

    //案件作成完了
    public function complete() {
        return view('projects.complete');
    }
}
