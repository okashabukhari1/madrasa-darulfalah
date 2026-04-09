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
        Schema::table('students', function (Blueprint $table) {
            $table->string('urdu_name')->nullable()->after('user_id');
        });

        Schema::table('teachers', function (Blueprint $table) {
            $table->string('urdu_name')->nullable()->after('name');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->string('urdu_title')->nullable()->after('title');
            $table->text('urdu_description')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('urdu_name');
        });

        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn('urdu_name');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['urdu_title', 'urdu_description']);
        });
    }
};
