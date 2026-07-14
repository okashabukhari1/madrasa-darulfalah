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
        if (!Schema::hasColumn('books', 'book_category_id')) {
            Schema::table('books', function (Blueprint $table) {
                $table->foreignId('book_category_id')->nullable()->after('author')->constrained('book_categories')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('books', 'book_category_id')) {
            Schema::table('books', function (Blueprint $table) {
                $table->dropConstrainedForeignId('book_category_id');
            });
        }
    }
};
