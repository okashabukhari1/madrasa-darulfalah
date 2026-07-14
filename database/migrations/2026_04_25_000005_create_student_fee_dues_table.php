<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_fee_dues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('fee_plan_id')->nullable()->constrained('fee_plans')->nullOnDelete();

            $table->unsignedSmallInteger('year');
            $table->unsignedTinyInteger('month'); // 1-12
            $table->decimal('amount', 12, 2);
            $table->enum('status', ['due', 'paid', 'waived'])->default('due');

            $table->date('due_date')->nullable();
            $table->timestamp('generated_at')->nullable();

            // optional link to collected fee record
            $table->unsignedBigInteger('fee_id')->nullable();

            $table->timestamps();

            $table->unique(['student_id', 'year', 'month']);
            $table->index(['year', 'month', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_fee_dues');
    }
};

