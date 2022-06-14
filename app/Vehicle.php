<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    public function vehicle_work_schedules()
    {
        return $this->hasMany('App\VehicleWorkSchedule');
    }
}
