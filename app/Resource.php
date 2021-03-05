<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    /**
     *  Resource_stockモデルにリレーションの設定
     */
    public function resource_stocks()
    {
        return $this->hasMany('App\Resource_stock');
    }
}
