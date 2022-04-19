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
    
    public static function boot()
    {
      parent::boot();
  
      static::deleting(function($client_group) {
        $client_group->trades()->delete();
      });
    }

    protected $fillable = [
        'client_name',
        'capital_amount',
        'annual_sales_1',
        'annual_sales_2',
        'annual_sales_3',
        'credit_score',
        'credit_line',
        'account_receivable_balance',
    ];

}
