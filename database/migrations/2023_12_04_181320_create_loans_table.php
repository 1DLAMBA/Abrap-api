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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // Adds a foreign key column
            $table->decimal('loan_amount', 10, 2);
            $table->integer('installment_period');
            $table->decimal('monthly_interest', 10, 2);
            $table->decimal('interest', 10, 2);
            $table->decimal('monthly_payment_without_interest', 10, 2);
            $table->integer('loan_period');
            $table->integer('months_paid')->default(0);
            $table->integer('months_left');
            $table->decimal('total_repayment', 10, 2);
            $table->decimal('monthly_payment_with_interest', 10, 2);
            $table->decimal('amount_paid_so_far', 10, 2);
            $table->decimal('outstanding', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
