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
        Schema::create('sanctions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('fee_id')->nullable();
            $table->unsignedBigInteger('attendance_id')->nullable();

            $table->string('type'); // Example: 'attendance', 'finance'
            $table->decimal('fine_amount', 8, 2)->nullable(); // Fine amount, nullable if there's no fine
            $table->text('required_action')->nullable(); // Required action to resolve the sanction
            $table->boolean('resolved')->default(false);
            $table->foreignId('semester_id')->nullable()->constrained('semesters'); // Semester reference
            $table->string('school_year')->nullable(); // School year reference
            $table->timestamps();

            $table->foreign('fee_id')->references('id')->on('fees')->onDelete('set null');
            $table->foreign('attendance_id')->references('id')->on('attendances')->onDelete('set null');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sanctions');
    }
};
