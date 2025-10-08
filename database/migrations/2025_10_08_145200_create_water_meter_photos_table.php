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
        Schema::create('water_meter_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('block_id')->nullable()->constrained('resident_blocks')->onDelete('cascade');
            $table->foreignId('water_period_id')->constrained('water_periods')->onDelete('cascade');
            $table->string('image_path');
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            // Add unique constraint to prevent duplicate uploads for same block and period
            $table->unique(['block_id', 'water_period_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('water_meter_photos');
    }
};
