<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanStatus extends Model
{
    protected $table = 'loan_status';

//    public function loan()
//    {
//        return $this->belongsTo('App\Loan', 'status_id', 'id');
//    }
}
