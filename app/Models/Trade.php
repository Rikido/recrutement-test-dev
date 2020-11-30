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
    
    public static function boot()
    {
      parent::boot();
  
      static::deleting(function($trade_group) {
        $trade_group->repayments()->delete();
      });
    }

    protected $fillable = [
        'transaction_amount',
        'transaction_balance',
        'months_of_term',
        'client_id',
        'trade_score',
    ];
}
