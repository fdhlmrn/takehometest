<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\LoanResource;
use App\Loan;
use App\LoanFrequency;
use App\LoanStatus;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoanController extends Controller
{
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

    public function getFrequency()
    {
        $frequency = LoanFrequency::get();
        return response($frequency, 201);
    }

    public function getStatus()
    {
        $status = LoanStatus::get();
        return response($status, 201);
    }

    public function getCurrentUser()
    {
        $curUser = auth()->guard('api')->user();
        return response($curUser, 201);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'loan_name' => 'required|max:255',
            'user_id' => 'required',
            'frequency_id' => 'required',
            'loan_term' => 'required|regex:^[0-9]{1,2}[:.,-]?$',
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
            'loan_balance' => $request->get('loan_amount'),
            'loan_term' => $request->get('loan_term'),
            'loan_currency' => $request->get('loan_currency')
        ]);

        $loan->save();


        return response([ 'loan' => new LoanResource($loan), 'message' => 'Created successfully'], 200);

    }

    public function show(Loan $loan)
    {
        $returnLoan = Loan::with(['status','frequency'])->findOrFail($loan->id);
        return response($returnLoan, 201);
    }

    public function update(Request $request, Loan $loan)
    {
        // Check if status exists
        $status = LoanStatus::findOrFail($request->status_id)->get();

        // Check for staff
        if(Auth()->user()->user_type != 1){
            return response(['Only Staff can update Loan Status']);
        }
        if(!$status){
            return response(['error', 'Validation Error']);
        }

        $loan->update($request->all());

        return response([ 'loan' => new LoanResource($loan), 'message' => 'Updated successfully'], 200);

    }

    public function destroy(Loan $loan)
    {
        $loan->delete();

        return response(['message' => 'Deleted']);
    }
}
