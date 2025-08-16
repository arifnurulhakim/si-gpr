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
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->string('family_card_number', 16)->unique();
            $table->string('head_of_family_name');
            $table->text('address');
            $table->string('rt', 3);
            $table->string('rw', 3);
            $table->string('village');
            $table->string('sub_district');
            $table->string('city');
            $table->string('province');
            $table->string('postal_code', 5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('families');
    }
};
