<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_work_schedule extends Model
{
    /**
     * User_work_scheduleを所有するuserを所得
     */
    public function user()
    {
        return $this->belongsTo('APP\User');
    }

    /**
     * User_work_scheduleを所有するprojectを所得
     */
    public function project()
    {
        return $this->belongsTo('APP\Project');
    }
}
