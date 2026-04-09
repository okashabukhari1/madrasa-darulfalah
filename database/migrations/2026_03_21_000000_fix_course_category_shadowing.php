<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Course;
use App\Models\Category;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Data Migration: If any courses have a string in 'category' but null 'category_id', try to link them.
        $courses = Course::whereNotNull('category')->whereNull('category_id')->get();
        foreach ($courses as $course) {
            $category = Category::where('name', 'like', $course->category)->first();
            if ($category) {
                $course->update(['category_id' => $category->id]);
            }
        }

        // 2. Drop the redundant string column 'category'
        Schema::table('courses', function (Blueprint $table) {
            if (Schema::hasColumn('courses', 'category')) {
                $table->dropColumn('category');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'category')) {
                $table->string('category')->nullable()->after('category_id');
            }
        });
    }
};
