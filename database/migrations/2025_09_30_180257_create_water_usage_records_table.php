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
        Schema::create('water_usage_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('family_id');
            $table->unsignedBigInteger('water_period_id');
            $table->decimal('initial_meter_reading', 10, 2);
            $table->decimal('final_meter_reading', 10, 2);
            $table->decimal('usage_amount', 10, 2);
            $table->decimal('bill_amount', 10, 2);
            $table->decimal('total_payment', 10, 2);
            $table->enum('payment_status', ['PENDING', 'OVERDUE', 'PAYMENT_UPLOADED', 'LUNAS', 'REJECTED'])->default('PENDING');
            $table->string('payment_proof_path')->nullable();
            $table->timestamp('payment_proof_uploaded_at')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->unsignedBigInteger('recorded_by');
            $table->timestamp('recorded_at')->nullable();
            $table->timestamps();

            $table->foreign('family_id')->references('id')->on('families')->onDelete('cascade');
            $table->foreign('water_period_id')->references('id')->on('water_periods')->onDelete('cascade');
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('recorded_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('water_usage_records');
    }
};
