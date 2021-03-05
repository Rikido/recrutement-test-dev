<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
     *  Resource_stockモデルにリレーションの設定
     */
    public function resource_stocks()
    {
        return $this_>hasMany('App\Resource_stock');
    }
}
