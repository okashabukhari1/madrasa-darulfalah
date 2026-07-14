<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_salary_payouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();

            $table->unsignedSmallInteger('year');
            $table->unsignedTinyInteger('month'); // 1-12

            $table->unsignedInteger('present_days')->default(0);
            $table->unsignedInteger('late_days')->default(0);
            $table->unsignedInteger('absent_days')->default(0);

            $table->decimal('base_salary', 12, 2)->default(0);
            $table->decimal('attendance_amount', 12, 2)->default(0);
            $table->decimal('advance_deduction', 12, 2)->default(0);
            $table->decimal('other_deduction', 12, 2)->default(0);
            $table->decimal('bonus', 12, 2)->default(0);

            $table->decimal('net_pay', 12, 2)->default(0);

            $table->enum('status', ['draft', 'paid'])->default('draft');
            $table->date('paid_date')->nullable();
            $table->string('note')->nullable();

            $table->timestamps();

            $table->unique(['teacher_id', 'year', 'month']);
            $table->index(['year', 'month', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_salary_payouts');
    }
};

