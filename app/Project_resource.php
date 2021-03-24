<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project_resource extends Model
{
    /**
     * Project_resourceを所有するprojectを取得する
     */
    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    /**
     * Project_resourceを所有するresourceを取得する
     */
    public function resource()
    {
        return $this->belongsTo('App\Resource');
    }

    /**
     * Project_resourceを所有するlocationを取得する
     */
    public function location()
    {
        return $this->belongsTo('App\Location');
    }
}
