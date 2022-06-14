<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectResource extends Model
{
    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function resource()
    {
        return $this->belongsTo('App\Resource');
    }

    public function location()
    {
        return $this->belongsTo('App\Location');
    }
}
