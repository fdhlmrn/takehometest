<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanFrequency extends Model
{
    protected $table = 'payment_frequency';

//    public function loan()
//    {
//        return $this->belongsTo('App\Loan', 'frequency_id', 'id');
//    }
}
