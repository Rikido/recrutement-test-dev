<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource_stock extends Model
{
    /**
     *  このResource_stockを所有するLocationを取得
     */
    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    /**
     *  このResource_stockを所有するResourceを取得
     */
    public function resource()
    {
        return $this->belongsTo('App\Resource');
    }
}
