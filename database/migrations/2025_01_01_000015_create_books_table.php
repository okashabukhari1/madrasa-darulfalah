<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('author')->nullable();
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_type')->nullable(); // pdf, link
            $table->string('external_link')->nullable();
            $table->integer('downloads')->default(0);
            $table->boolean('status')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
