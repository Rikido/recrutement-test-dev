<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;

class GroupsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index() {
        $groups = Group::all();
        return view('groups.index', compact('groups'));
    }
}
