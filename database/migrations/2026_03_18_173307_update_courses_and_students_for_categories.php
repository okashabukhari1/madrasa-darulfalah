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
        Schema::table('courses', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('slug')->constrained()->nullOnDelete();
            // We keep the old category column for now to migrate data later, 
            // but we can drop it if the user doesn't care about existing data.
            // For safety, I'll just add the new one.
        });

        Schema::table('students', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
        });
    }
};
