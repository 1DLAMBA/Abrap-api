<?php

namespace App\Services;
use App\Models\Loan;
use App\Models\User;

class LoanService
{
    public function createLoan(string $userId, mixed $loan_Amount, $installment_period, $adminInterest)
    {
        $user_id=$userId;
        $user=User::where('id',$userId)->firstOrFail();
        $admin_interest = $adminInterest;
        $has_loan=Loan::find($user_id);
        $loanAmount = $loan_Amount ;
        $installmentPeriod =$installment_period ;

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
        
        $loan->user_id = $userId;
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
}