<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     *  Groupモデルにリレーションを設定
     */
    public function groups()
    {
        return $this->belongsToMany('App\Group', 'group_users')->withTimestamps();
    }

    /**
     * user_work_schedulesモデルにリレーションを設定
     */
    public function user_work_schedules()
    {
        return $this->hasMany('App\User_work_schedule');
    }

    /**
     * vehicle_work_schedulesモデルにリレーションを設定
     */
    public function vehicle_work_schedules()
    {
        return $this->hasMany('App\Vehicle_work_schedule');
    }

    /**
     * task_chargesモデルにリレーションを設定
     */
    public function task_charges()
    {
        return $this->hasMany('App\Task_charge');
    }

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
