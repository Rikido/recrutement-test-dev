<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repayment extends Model
{
    //
    public function trades()
    {
        return $this->belongsTo('App\Models\Trade', 'foreign_key');
    }
}
