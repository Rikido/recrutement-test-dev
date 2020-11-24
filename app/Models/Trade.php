<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    //
    public function clients()
    {
        return $this->belongsTo('App\Models\Client', "client_id");
    }

    public function repayments()
    {
        return $this->hasMany('App\Models\Repayment');
    }

    protected $fillable = [
        'transaction_amount',
        'months_of_term',
        'client_id',
    ];
}
