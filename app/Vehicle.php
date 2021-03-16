<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    /**
     * vehicle_work_schedulesモデルにリレーションを設定
     */
    public function vehicle_work_schedules()
    {
        return $this->hasMany('App\Vehicle_work_schedule');
    }
}
