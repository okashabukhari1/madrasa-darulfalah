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
        Schema::table('announcements', function (Blueprint $table) {
            $table->string('urdu_title')->nullable()->after('title');
            $table->longText('urdu_content')->nullable()->after('content');
            $table->string('type')->default('all')->change();
        });
    }

    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn(['urdu_title', 'urdu_content']);
            $table->enum('type', ['general', 'academic', 'event', 'urgent'])->default('general')->change();
        });
    }
};
