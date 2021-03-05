<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     *  このProjectを所有するGroupを取得
     */
    public function group()
    {
        return $this->belongsTo('App\Group');
    }
}
