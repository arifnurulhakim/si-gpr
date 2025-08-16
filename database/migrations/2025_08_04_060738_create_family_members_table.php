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
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_id')->constrained()->onDelete('cascade');
            $table->string('nik', 16)->unique();
            $table->string('name');
            $table->enum('gender', ['L', 'P']);
            $table->date('date_of_birth');
            $table->enum('marital_status', ['BELUM KAWIN', 'KAWIN', 'CERAI HIDUP', 'CERAI MATI']);
            $table->enum('relationship_to_head', [
                'KEPALA KELUARGA', 'SUAMI', 'ISTRI', 'ANAK',
                'ORANGTUA', 'FAMILI LAIN', 'PEMBANTU', 'LAINNYA'
            ]);
            $table->string('citizenship', 3)->default('WNI');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_members');
    }
};
