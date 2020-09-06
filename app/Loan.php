<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'user_id', 'frequency_id', 'status_id', 'loan_name', 'loan_term', 'loan_balance', 'loan_amount', 'loan_currency'
    ];

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function status()
    {
        return $this->hasOne('App\LoanStatus', 'id', 'status_id');
    }

    public function frequency()
    {
        return $this->hasOne('App\LoanFrequency', 'id', 'frequency_id');
    }
}
