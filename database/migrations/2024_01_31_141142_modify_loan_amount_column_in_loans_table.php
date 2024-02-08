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
        Schema::table('loans', function (Blueprint $table) {
            $table->decimal('loan_amount', 15, 2)->change();
            $table->decimal('interest', 15, 2)->change();
            $table->decimal('total_repayment', 15, 2)->change();
            $table->decimal('outstanding', 15, 2)->change();
            // $table->decimal('interest', 15, 2)->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            //
        });
    }
};
