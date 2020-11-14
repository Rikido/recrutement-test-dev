<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    //
    public function clients()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function repayments()
    {
        return $this->hasMany('App\Models\Repayment');
    }
}
