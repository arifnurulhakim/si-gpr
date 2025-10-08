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
        Schema::table('family_members', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['family_id']);

            // Make family_id nullable
            $table->foreignId('family_id')->nullable()->change();

            // Re-add the foreign key constraint with nullable support
            $table->foreign('family_id')->references('id')->on('families')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('family_members', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['family_id']);

            // Make family_id not nullable again
            $table->foreignId('family_id')->nullable(false)->change();

            // Re-add the original foreign key constraint
            $table->foreign('family_id')->references('id')->on('families')->onDelete('cascade');
        });
    }
};
