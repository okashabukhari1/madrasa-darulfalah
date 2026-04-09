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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
            $table->string('program'); // Hifz, Nazra, Qaida
            $table->string('exam_type'); // Daily, Weekly, Monthly, Completion
            $table->date('date');
            
            // Evaluation Fields
            $table->integer('para')->nullable();
            $table->string('surah')->nullable();
            $table->integer('ayah_from')->nullable();
            $table->integer('ayah_to')->nullable();
            
            // Metrics
            $table->integer('mistakes')->default(0);
            $table->integer('fluency')->nullable(); // e.g. 1-5
            $table->integer('tajweed')->nullable(); // e.g. 1-5
            
            $table->string('grade'); // Excellent, Good, Average, Weak
            $table->text('remarks')->nullable();
            
            $table->timestamps();

            // Prevent duplicate daily test for same student + date + type
            $table->unique(['student_id', 'exam_type', 'date']);
            
            // Indexing for performance
            $table->index(['student_id', 'date']);
            $table->index(['teacher_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
