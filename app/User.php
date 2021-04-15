<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public function groups()
    {
        return $this->belongsToMany('App\Group', 'group_users')->withTimestamps();
    }

    public function task_charges()
    {
        return $this->hasMany('App\TaskCharge');
    }

    public function user_work_schedules()
    {
        return $this->hasMany('App\UserWorkSchedule');
    }

    public function vehicle_work_schedules()
    {
        return $this->hasMany('App\VehicleWorkSchedule');
    }

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
