<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    protected $fillable = ['user_id', 'date', 'in_time', 'up_time','break_time','paid_holidays_status','fix_status'];
    protected $table = 'attendances';
}
