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
        Schema::create('cash_periods', function (Blueprint $table) {
            $table->id();
            $table->string('period_name');
            $table->string('period_code', 7)->unique(); // Format: 2025-08
            $table->date('due_date');
            $table->decimal('cash_amount', 10, 2)->default(0); // Uang Kas
            $table->decimal('patrol_amount', 10, 2)->default(0); // Uang Ronda
            $table->decimal('other_amount', 10, 2)->default(0); // Lain-lain
            $table->decimal('admin_fee', 10, 2)->default(0);
            $table->enum('status', ['ACTIVE', 'CLOSED', 'ARCHIVED'])->default('ACTIVE');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_periods');
    }
};
