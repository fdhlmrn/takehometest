<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table= 'Payment';

    protected $fillable = [
        'user_id', 'loan_id', 'pay_amount'
    ];

    public function loan()
    {
        return $this->belongsTo('App\Loan', 'loan_id' ,'id');
    }
}
