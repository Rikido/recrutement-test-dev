<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateProjectResources;
use App\Resource;
use App\Project;

class ProjectResourcesController extends Controller
{
    // projectで使用するresourceの選択画面の表示
    public function resourceSelect($id)
    {
        $project = Project::findOrFail($id);
        $resources = Resource::all();
        return view('project_resources.create', compact('project', 'resources'));
    }

    public function resourceSelectStore(CreateProjectResources $request)
    {
        $projectResource = $request->input('project_resource');
        $projectId = $request->input('project_id');

        // 空の配列を削除する
        foreach( $projectResource as $project_resource => $project_resource_copy)
        {
            if( $project_resource_copy["resource"] == null) unset($projectResource[$project_resource]);
        };

        // セッションに値を保存
        $request->session()->put(["projectResource" => $projectResource, 'projectId' => $projectId]);

        return redirect()->action('TaskChargesController@taskChargesCreate', ['id' => $projectId]);
    }

}
