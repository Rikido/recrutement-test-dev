<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     *  このProjectを所有するGroupを取得
     */
    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    /**
     * Task_chargeモデルにリレーションを設定
     */
    public function task_charges()
    {
        return $this->hasMany('App\Task_charge');
    }

    /**
     * User_work_scheduleモデルにリレーションを設定
     */
    public function user_work_schedules()
    {
        return $this->hasMany('App\User_work_schedule');
    }

    /**
     * Vehicle_work_schedulesモデルにリレーションを設定
     */
    public function vehicle_work_schedules()
    {
        return $this->hasMany('App\Vehicle_work_schedule');
    }
}
