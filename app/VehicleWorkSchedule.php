<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleWorkSchedule extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function vehicle()
    {
        return $this->belongsTo('App\Vehicle');
    }
}
