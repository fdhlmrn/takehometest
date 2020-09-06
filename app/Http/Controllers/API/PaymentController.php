<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Loan;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function getPayment(Loan $loan)
    {
        $payment = Payment::with('loan')->where('loan_id', $loan->id)->get();
        return response($payment, 201);
    }

    public function makePayment(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [

            'user_id' => 'required',
            'loan_id' => 'required'
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

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

        $loan->loan_balance = $loan->loan_balance - $pay_amount;

        $payment->save();
        $loan->save();

        return response([$payment, 'message' => 'Payment received'], 201);
        //return response(['loans' => LoanResource::collection($loans), 'message' => 'Retrieved all loans successfully'], 200);
    }
}
