<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Update students table
        Schema::table('students', function (Blueprint $table) {
            $table->enum('program', ['hifz', 'nazra', 'qaida'])->nullable()->after('student_id');
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->nullOnDelete()->after('program');
            $table->string('guardian_name')->nullable()->after('father_name');
            $table->string('guardian_phone')->nullable()->after('guardian_name');
        });

        // 2. Update attendances table (make course_id nullable, drop unique, add new unique)
        // Note: we just make course_id nullable and add a new unique constraint if possible.
        // To be safe regarding SQLite limits, we will modify course_id to be nullable.
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropUnique(['student_id', 'course_id', 'date']);
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->foreignId('course_id')->nullable()->change();
            $table->unique(['student_id', 'date']);
        });

        // 3. Create progress_logs table
        Schema::create('progress_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->date('date');
            
            $table->integer('para')->nullable();
            $table->string('surah')->nullable();
            $table->string('ayah_from')->nullable();
            $table->string('ayah_to')->nullable();
            $table->enum('lesson_type', ['sabaq', 'sabqi', 'manzil'])->nullable();
            $table->text('remarks')->nullable();
            
            $table->timestamps();

            $table->unique(['student_id', 'date']);
            $table->index('date');
            $table->index(['student_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('progress_logs');

        Schema::table('attendances', function (Blueprint $table) {
            $table->dropUnique(['student_id', 'date']);
            $table->unique(['student_id', 'course_id', 'date']);
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->dropColumn(['program', 'teacher_id', 'guardian_name', 'guardian_phone']);
        });
    }
};
