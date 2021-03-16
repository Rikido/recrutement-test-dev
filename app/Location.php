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
        return $this->hasMany('App\Resource_stock');
    }

    /**
     *  Project_resourceモデルにリレーションの設定
     */
    public function project_resources()
    {
        return $this->hasMany('App\Project_resource');
    }
}
