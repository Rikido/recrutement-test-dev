<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function group()
    {
        return $this->hasOne('App\Group');
    }
}
