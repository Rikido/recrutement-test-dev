<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    public function task_charges()
    {
        return $this->hasMany('App\TaskCharge');
    }

    public function user_work_schedules()
    {
        return $this->hasMany('App\UserWorkSchedule');
    }

    public function project_resources()
    {
        return $this->hasMany('App\ProjectResource');
    }

    public function vehicle_work_schedules()
    {
        return $this->hasMany('App\VehicleWorkSchedule');
    }
}
