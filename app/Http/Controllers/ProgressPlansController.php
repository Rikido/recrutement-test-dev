<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProgressPlansController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    // 利用資材入力画面
    public function resource($id) {
        $project = Project::findOrFail($id);
        $file_name = str_replace('public/', '', $project->file_path);
        return view('progress_plans.resource', compact('project', 'file_name'));
    }

    // 設計書PDFデータのダウンロード
    public function download($id) {
        $project = Project::findOrFail($id);
        // pdfファイル名取得
        $file_name = str_replace('public/', '', $project->file_path);
        // storage_pathでstorageディレクトリのフルパスを取得し、pdfファイルのパスを生成
        // /var/www/lamp/storage/app/public/pdfファイル名
        $file_path = storage_path("/app/public/$file_name");
        // ファイルダウンロード
        return response()->download($file_path, $file_name);
    }
}

