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
        Schema::create('resident_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('block', 10); // Format: D1-12, D1-12A, etc.
            $table->foreignId('resident_id')->constrained('family_members')->onDelete('cascade');
            $table->timestamps();

            // Ensure one resident can only have one block
            $table->unique('resident_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resident_blocks');
    }
};
