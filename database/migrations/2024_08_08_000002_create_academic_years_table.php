<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_years', function (Blueprint $table) {
            $table->id();
            $table->string('school_year'); // e.g., "2023-2024"
            $table->foreignId('semester_id')->constrained('semesters')->onDelete('cascade');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {


        Schema::dropIfExists('academic_years');
    }
};
