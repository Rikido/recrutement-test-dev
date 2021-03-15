<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
    public function index()
    {
        $groups = Group::with('users')->get();
 
        return view('groups', [ 'groups' => $groups ]);
    }
}
