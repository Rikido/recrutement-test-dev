<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     *  Userモデルにリレーションを設定
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'group_users')->withTimestamps();
    }

    /**
     *  Projectモデルにリレーションを設定
     */
    public function projects()
    {
        return $this->hasMany('App\Project');
    }
}
