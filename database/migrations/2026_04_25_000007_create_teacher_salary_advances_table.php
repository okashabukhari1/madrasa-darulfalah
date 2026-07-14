<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_salary_advances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->date('advance_date');
            $table->string('reason')->nullable();
            $table->enum('status', ['open', 'settled'])->default('open');
            $table->timestamps();

            $table->index(['teacher_id', 'status']);
            $table->index('advance_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_salary_advances');
    }
};

