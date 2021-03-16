<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle_work_schedule extends Model
{
    /**
     * Vehicle_work_scheduleを所有するUserを取得
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Vehicle_work_scheduleを所有するVehicleを取得
     */
    public function vehicle()
    {
        return $this->belongsTo('App\Vehicle');
    }

    /**
     * Vehicle_work_scheduleを所有するProjectを取得
     */
    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
