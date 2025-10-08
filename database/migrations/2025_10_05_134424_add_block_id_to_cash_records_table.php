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
        Schema::table('cash_records', function (Blueprint $table) {
            // Add block_id column
            $table->unsignedBigInteger('block_id')->nullable()->after('family_id');

            // Add foreign key constraint
            $table->foreign('block_id')->references('id')->on('resident_blocks')->onDelete('cascade');

            // Add index for better performance
            $table->index('block_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cash_records', function (Blueprint $table) {
            $table->dropForeign(['block_id']);
            $table->dropIndex(['block_id']);
            $table->dropColumn('block_id');
        });
    }
};
