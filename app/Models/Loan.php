<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'full_name',
        'loan_amount',
        'installment_period',
        'monthly_interest',
        'interest',
        'monthly_payment_without_interest',
        'loan_period',
        'months_paid',
        'months_left',
        'total_repayment',
        'monthly_payment_with_interest',
        'amount_paid_so_far',
        'outstanding',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
