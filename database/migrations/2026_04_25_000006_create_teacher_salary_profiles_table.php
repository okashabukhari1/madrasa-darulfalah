<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_salary_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->unique()->constrained('teachers')->cascadeOnDelete();

            $table->decimal('base_salary', 12, 2)->default(0);
            $table->decimal('per_present_day', 12, 2)->default(0); // attendance-based component
            $table->decimal('per_late_day', 12, 2)->default(0);
            $table->decimal('per_absent_day', 12, 2)->default(0); // usually 0

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_salary_profiles');
    }
};

