<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public function item(){
        return $this->belongsTo('App\Models\Item');
    }
}
