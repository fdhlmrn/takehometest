<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Loan;
use App\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{


    public function makePayment(Request $request)
    {
        $loan = Loan::findOrFail($request->get('loan_id'));
        if($loan->frequency_id == 1)
        {
            $pay_amount = ($loan->loan_amount / ( $loan->loan_term * 12 * 4));
        } else if ($loan->frequency_id == 2)
        {
            $pay_amount = ($loan->loan_amount / ( $loan->loan_term * 12 * 2));
        } else
        {
            $pay_amount = ($loan->loan_amount / ( $loan->loan_term * 12 * 1));
        }

        $payment = new Payment([
            'user_id' => $request->get('user_id'),
            'loan_id' => $request->get('loan_id'),
            'pay_amount' => $pay_amount,
        ]);
        $payment->save();
        return response([$payment, 'message' => 'Payment received'], 201);
        //return response(['loans' => LoanResource::collection($loans), 'message' => 'Retrieved all loans successfully'], 200);
    }
}
