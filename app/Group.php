<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User', 'group_users')->withTimestamps();
    }

    public function projects()
    {
        return $this->hasMany('App\Project');
    }
}
