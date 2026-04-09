<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('file_path')->nullable();
            $table->string('file_type')->nullable();
            $table->string('file_size')->nullable();
            $table->foreignId('course_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('type', ['lecture', 'assignment', 'notes', 'video', 'other'])->default('notes');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
