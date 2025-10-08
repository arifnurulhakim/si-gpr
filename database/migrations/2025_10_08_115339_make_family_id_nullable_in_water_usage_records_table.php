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
            // Make family_id nullable
            $table->unsignedBigInteger('family_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('water_usage_records', function (Blueprint $table) {
            // Make family_id not nullable again
            $table->unsignedBigInteger('family_id')->nullable(false)->change();
        });
    }
};
