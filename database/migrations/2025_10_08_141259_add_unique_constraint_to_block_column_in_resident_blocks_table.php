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
        Schema::table('resident_blocks', function (Blueprint $table) {
            // Add unique constraint to ensure one block can only be assigned to one resident/family
            $table->unique('block');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resident_blocks', function (Blueprint $table) {
            // Remove the unique constraint
            $table->dropUnique(['block']);
        });
    }
};
