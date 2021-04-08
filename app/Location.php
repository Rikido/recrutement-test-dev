<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public function resource_stocks()
    {
        return $this->hasMany('App\ResourceStock');
    }

    public function project_resources()
    {
        return $this->hasMany('App\ProjectResource');
    }
}
