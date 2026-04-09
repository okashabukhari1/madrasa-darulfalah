<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique(); // STD000001
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('father_name')->nullable();
            $table->string('cnic', 20)->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('class')->nullable();
            $table->string('batch')->nullable();
            $table->date('enrollment_date')->nullable();
            $table->enum('status', ['active', 'inactive', 'graduated', 'expelled'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
