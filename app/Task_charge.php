<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task_charge extends Model
{
    /**
     * このtask_chargeを所有するuserを取得
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * このtask_chargeを所有するprojectを取得
     */
    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
