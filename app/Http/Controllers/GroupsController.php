<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// モデル定義
use App\Group;

class GroupsController extends Controller
{
    public function index() {
        // リレーションを取得するときはwithを使う（Model::with('リレーション名')->get();）
        $groups = Group::with('users')->get();
        // 取得した値をビュー「groups/index」に渡す
        return view('groups.index', compact('groups'));
    }
}
