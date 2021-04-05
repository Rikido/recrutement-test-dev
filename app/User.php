<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public function groups()
    {
        // 多:多はhasManyではなくbelongsToMany
        // belongsToManyの第2引数に結合テーブルの名前を渡してオーバーライド
        // withTimestampsメソッドをリレーション定義に付けることで中間テーブルのcreated_at、updated_atタイムスタンプを自動的に更新
        return $this->belongsToMany('App\Group', 'group_users')->withTimestamps();
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
