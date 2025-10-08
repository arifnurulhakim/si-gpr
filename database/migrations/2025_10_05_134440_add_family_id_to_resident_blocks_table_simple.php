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
            // Add family_id column for 1:1 relationship
            $table->unsignedBigInteger('family_id')->nullable()->after('resident_id');

            // Add foreign key constraint
            $table->foreign('family_id')->references('id')->on('families')->onDelete('cascade');

            // Add unique constraint to enforce 1 block = 1 KK
            $table->unique('family_id');

            // Add index for better performance
            $table->index('family_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resident_blocks', function (Blueprint $table) {
            $table->dropForeign(['family_id']);
            $table->dropUnique(['family_id']);
            $table->dropIndex(['family_id']);
            $table->dropColumn('family_id');
        });
    }
};
