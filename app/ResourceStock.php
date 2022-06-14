<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResourceStock extends Model
{
    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    public function resource()
    {
        return $this->belongsTo('App\Resource');
    }

}
