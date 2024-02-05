<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */

     
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request->validate([
            'user_id'=>'',
            'loan_amount' => 'required|numeric|min:1',
            'installment_period' => 'required|integer|min:1',
        ]);

        // Extract input data
        $user_id=$request->input('user_id');
        $has_loan=Loan::find($user_id);
        $loanAmount = $request->input('loan_amount');
        $installmentPeriod = $request->input('installment_period');

        // Calculate other loan details
        $monthlyInterestRate = 3.5 / 100;
        $monthlyInterest = $loanAmount * $monthlyInterestRate;
        $interest = $installmentPeriod * $monthlyInterest;
        $monthlyPaymentWithoutInterest = $loanAmount / $installmentPeriod;
        $loanPeriod = $installmentPeriod; // Assuming loan period is the same as installment period initially
        $monthsPaid = 0;
        $monthsLeft = $installmentPeriod;
        $totalRepayment = $loanAmount + $interest;
        $monthlyPaymentWithInterest = $totalRepayment / $loanPeriod;
        $amountPaidSoFar = 0;
        $outstanding = $totalRepayment;

       

        // Insert data into the Loan table
        $loan = new Loan();
        
        $loan->user_id = $$this->userId;
        $loan->loan_amount = $loanAmount;
        $loan->installment_period = $installmentPeriod;
        $loan->monthly_interest = $monthlyInterest;
        $loan->interest = $interest;
        $loan->monthly_payment_without_interest = $monthlyPaymentWithoutInterest;
        $loan->loan_period = $loanPeriod;
        $loan->months_paid = $monthsPaid;
        $loan->months_left = $monthsLeft;
        $loan->total_repayment = $totalRepayment;
        $loan->monthly_payment_with_interest = $monthlyPaymentWithInterest;
        $loan->amount_paid_so_far = $amountPaidSoFar;
        $loan->outstanding = $outstanding;
        $loan->save();
        
        return response()->json([
            'loan'=>$loan
        ]);

    }

    public function recreate(Request $request)
    {
        $request->validate([
            'user_id'=>'',
            'loan_amount' => 'required|numeric|min:1',
            'installment_period' => 'required|integer|min:1',
        ]);

        // Extract input data
        $user_id=$request->input('user_id');
        $has_loan=Loan::find($user_id);
        $loanAmount = $request->input('loan_amount');
        $user=User::where('id',$user_id)->firstOrFail();
        $admin_interest = $user->admin_interest;
        $installmentPeriod = $request->input('installment_period');
        $user->loan_amount = $loanAmount;
        $user->installment_period = $installmentPeriod;
        $user->save();


        // Calculate other loan details
        $monthlyInterestRate = $admin_interest / 100;
        $monthlyInterest = $loanAmount * $monthlyInterestRate;
        $interest = $installmentPeriod * $monthlyInterest;
        $monthlyPaymentWithoutInterest = $loanAmount / $installmentPeriod;
        $loanPeriod = $installmentPeriod; // Assuming loan period is the same as installment period initially
        $monthsPaid = 0;
        $monthsLeft = $installmentPeriod;
        $totalRepayment = $loanAmount + $interest;
        $monthlyPaymentWithInterest = $totalRepayment / $loanPeriod;
        $amountPaidSoFar = 0;
        $outstanding = $totalRepayment;

       

        // Insert data into the Loan table
        $loan = new Loan();
        
        $loan->user_id = $request->input('user_id');
        $loan->loan_amount = $loanAmount;
        $loan->installment_period = $installmentPeriod;
        $loan->monthly_interest = $monthlyInterest;
        $loan->interest = $interest;
        $loan->monthly_payment_without_interest = $monthlyPaymentWithoutInterest;
        $loan->loan_period = $loanPeriod;
        $loan->months_paid = $monthsPaid;
        $loan->months_left = $monthsLeft;
        $loan->total_repayment = $totalRepayment;
        $loan->monthly_payment_with_interest = $monthlyPaymentWithInterest;
        $loan->amount_paid_so_far = $amountPaidSoFar;
        $loan->outstanding = $outstanding;
        $loan->save();
        
        return response()->json([
            'loan'=>$loan
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function show(Loan $loanId)
    {
        $loan = Loan::findOrFail($loanId);

        return response()->json([
          'loans'=>$loan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        Log::debug($request->admin_charges);
       $request->validate([
            'admin_charges'=> 'required|string'
        ]);
        $user = Loan::where('user_id', $id)->firstOrFail();
        $user->admin_charges = $request->admin_charges;
        $user->save();

        return response()->json([
            'success' => 'operation succesful'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $loanId)
    {
        

        // Retrieve the loan record from the database
        $loan = Loan::findOrFail($loanId);

        // Extract input data
      

        // Update loan details based on payment
        $loan->months_paid += 1;
        $loan->months_left -= 1;
        $loan->amount_paid_so_far += $loan->monthly_payment_with_interest;
        $loan->outstanding -=$loan->monthly_payment_with_interest;

        // Save the updated loan details
        $loan->save();
        Log::alert('clicked');
        return response()->json(['success' => 'User has paid']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $loan = Loan::where('user_id', $id)->first();

        if ($loan) {
            $loan->delete();
        }
    
        $user = User::findOrFail($id);
    
        // Set the columns to null
        $user->installment_period = null;
        $user->loan_amount = null;
        $user->active = null;
    
        $user->save();
    
        return response()->json(['success' => 'Operation Successful']);

    }
}
