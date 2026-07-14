<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->id();

            // Linkage by public IDs (keeps MDF requirement: STD000001 / TH00001)
            $table->string('student_id', 9); // STD000001
            $table->string('teacher_id', 7)->nullable(); // TH00001

            $table->string('name');
            $table->string('phone', 20)->nullable();
            $table->decimal('amount', 12, 2);

            $table->enum('payment_type', ['Khalis', 'Zakat', 'Hadiya', 'Sadqa', 'Fitra', 'Fidya', 'Others']);
            $table->enum('status', ['paid', 'pending'])->default('paid');

            $table->string('check_no')->nullable();
            $table->string('bank')->nullable();
            $table->date('payment_date');

            $table->string('reference_id')->unique(); // MDF-2026-0001

            $table->timestamps();

            $table->index('student_id');
            $table->index('teacher_id');
            $table->index('payment_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
};

