<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public function users()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function trades()
    {
        return $this->hasMany('App\Models\Trade');
    }

    protected $fillable = [
        'client_name',
        'capital_amount',
        'annual_sales_1',
        'annual_sales_2',
        'annual_sales_3',
    ];

}
