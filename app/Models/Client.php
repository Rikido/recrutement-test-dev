<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    public function users()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function trades()
    {
        return $this->hasMany('App\Models\Trade');
    }
}
