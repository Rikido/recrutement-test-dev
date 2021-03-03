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
        return $this->belongsToMany('App\User');
    }
}
