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
        Schema::table('water_usage_records', function (Blueprint $table) {
            // Check if block_id column exists, if not add it
            if (!Schema::hasColumn('water_usage_records', 'block_id')) {
                $table->unsignedBigInteger('block_id')->nullable()->after('family_id');

                // Add foreign key constraint
                $table->foreign('block_id')->references('id')->on('resident_blocks')->onDelete('cascade');

                // Add index for better performance
                $table->index('block_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('water_usage_records', function (Blueprint $table) {
            // Only drop if column exists
            if (Schema::hasColumn('water_usage_records', 'block_id')) {
                // Drop foreign key and index first
                $table->dropForeign(['block_id']);
                $table->dropIndex(['block_id']);

                // Drop the column
                $table->dropColumn('block_id');
            }
        });
    }
};
