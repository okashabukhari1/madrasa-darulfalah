<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fee_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            // Targeting rules (nullable means "any")
            $table->enum('program', ['hifz', 'nazra', 'qaida'])->nullable();
            $table->string('class')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();

            $table->decimal('monthly_amount', 12, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['program', 'class']);
            $table->index('course_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_plans');
    }
};

