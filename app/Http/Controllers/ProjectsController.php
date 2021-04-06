<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Project;

class ProjectsController extends Controller
{
    public function index() {
        $projects = Project::all();

        return view('projects.index');
    }

    public function show() {

        return view('projects.show');
    }

    public function create() {

        return view('projects.create');
    }

    public function post() {

    }

    public function comfirm() {

        return view('projects.comfirm');
    }

    public function register() {

    }

    public function complete() {

        return view('projects.complete');
    }
}
