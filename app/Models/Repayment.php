<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repayment extends Model
{
    //
    public function trades()
    {
        return $this->belongsTo('App\Models\Trade', "trade_id");
    }

    protected $fillable = [
        'payment_month',
        'trade_id',
        'amount',
        'delay_flag',
        'credit_minus',
    ];
}
