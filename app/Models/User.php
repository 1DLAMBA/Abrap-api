<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'country',
        'phoneno',
        'state',
        'city',
        'address',
        'identification_type',
        'identification_type2',
        'nin',
        'voters_card',
        'international_passport',
        'drivers_license',
        'identification_number1',
        'identification_number2',
        'identification_file1',
        'identification_file2',
        'installment_period',
        'employer_phoneno',
        'bank',
        'account_number',
        'account_name',
        'active',
        'passport',
        'has_loan',
        'loan_amount',
        'guarantor1_name',
        'guarantor1_address',
        'guarantor1_phoneno',
        'guarantor1_identification_type1',
        'guarantor1_identification1',
        'guarantor1_identification_file1',
        'guarantor1_identification_type2',
        'guarantor1_identification2',
        'guarantor1_identification_file2',
        'guarantor2_name',
        'guarantor2_address',
        'guarantor2_phoneno',
        'guarantor2_identification_type1',
        'guarantor2_identification1',
        'guarantor2_identification_file1',
        'guarantor2_identification_type2',
        'guarantor2_identification2',
        'guarantor2_identification_file2',
        'purpose_of_loan',
        'approved',
        'contract',
        'admin_interest',
        'email_verified_at',
        'password',
        
    ];
    public function loans()
    {
        return $this->hasOne(Loan::class);
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
