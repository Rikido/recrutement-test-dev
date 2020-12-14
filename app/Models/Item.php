<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function purchases(){
        return $this->hasMany('App\Models\Purchase');
    }
    public function receipts(){
        return $this->hasMany('App\Models\Receipt');
    }
    public function allocates(){
        return $this->hasMany('App\Models\Allocate');
    } 
}
