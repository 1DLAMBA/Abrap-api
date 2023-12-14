<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('country')->nullable();
            $table->string('phoneno')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('approved')->nullable();
            $table->string('identification_type')->nullable();
            $table->string('identification_type2')->nullable();
            $table->string('nin')->nullable();
            $table->string('voters_card')->nullable();
            $table->string('international_passport')->nullable();
            $table->string('drivers_license')->nullable();
            $table->string('identification_number1')->nullable();
            $table->string('identification_number2')->nullable();
            $table->string('identification_file1')->nullable();
            $table->string('identification_file2')->nullable();
            $table->string('installment_period')->nullable();
            $table->string('employer_phoneno')->nullable();
            $table->string('has_loan')->nullable();
            $table->string('loan_amount')->nullable();
            $table->string('guarantor1_name')->nullable();
            $table->string('guarantor1_address')->nullable();
            $table->string('guarantor1_phoneno')->nullable();
            $table->string('guarantor1_identification1')->nullable();
            $table->string('guarantor1_identification_type1')->nullable();
            $table->string('guarantor1_identification_file1')->nullable();
            $table->string('guarantor1_identification2')->nullable();
            $table->string('guarantor1_identification_type2')->nullable();
            $table->string('guarantor1_identification_file2')->nullable();
            $table->string('guarantor2_name')->nullable();
            $table->string('account_name')->nullable();
            $table->string('guarantor2_address')->nullable();
            $table->string('guarantor2_phoneno')->nullable();
            $table->string('guarantor2_identification1')->nullable();
            $table->string('guarantor2_identification_type1')->nullable();
            $table->string('guarantor2_identification_file1')->nullable();
            $table->string('guarantor2_identification2')->nullable();
            $table->string('guarantor2_identification_type2')->nullable();
            $table->string('guarantor2_identification_file2')->nullable();
            $table->string('purpose_of_loan')->nullable()->default('Business');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
