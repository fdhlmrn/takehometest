<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\LoanResource;
use App\Loan;
use App\LoanFrequency;
use App\LoanStatus;
use App\Payment;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->guard('api')->user()->user_type == 1)
        {
            $loans = Loan::with(['status','frequency'])->get();
        }
        else
        {
            $loans = Loan::with(['status','frequency'])
                ->whereUserId(auth()->guard('api')->user()->id)
                ->get();
        }
        return response($loans, 201);
        //return response(['loans' => LoanResource::collection($loans), 'message' => 'Retrieved all loans successfully'], 200);
    }

    /**
     * Get frequency list
     *
     * @return \Illuminate\Http\Response
     */
    public function getFrequency()
    {
        $frequency = LoanFrequency::get();
        return response($frequency, 201);
    }

    /**
     * Get status list
     *
     * @return \Illuminate\Http\Response
     */
    public function getStatus()
    {
        $status = LoanStatus::get();
        return response($status, 201);
    }

    /**
     * Get current user object
     *
     * @return \Illuminate\Http\Response
     */
    public function getCurrentUser()
    {
        $curUser = auth()->guard('api')->user();
        return response($curUser, 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'loan_name' => 'required|max:255',
            'loan_amount' => "required|regex:/^\d+(\.\d{1,2})?$/",
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation Error']);
        }
        $loan = new Loan([
            'user_id' => $request->get('user_id'),
            'frequency_id' => $request->get('frequency_id'),
            'loan_name' => $request->get('loan_name'),
            'loan_amount' => $request->get('loan_amount'),
            'loan_term' => $request->get('loan_term'),
            'loan_currency' => $request->get('loan_currency')
        ]);

        $loan->save();


        return response([ 'loan' => new LoanResource($loan), 'message' => 'Created successfully'], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show(Loan $loan)
    {
        $returnLoan = Loan::with(['status','frequency'])->findOrFail($loan->id);
        $payment = Payment::with('loan')->where('loan_id', $loan->id)->get();
        return response([$returnLoan,$payment], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Loan $loan)
    {

        // Check for staff
        if(Auth()->user()->user_type != 1){
            return response(['Only Staff can update Loan Status']);
        }

        $loan->update($request->all());

        return response([ 'loan' => new LoanResource($loan), 'message' => 'Updated successfully'], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan)
    {
        $loan->delete();

        return response(['message' => 'Deleted']);
    }
}
