<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For MySQL, we need to change the enum. 
        // Note: doctrine/dbal doesn't support changing enums easily, so we use raw SQL if needed,
        // but for now let's try the standard Laravel way which works in many cases or use a string if preferred for flexibility.
        
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'student', 'user'])->default('user')->change();
        });
    }
};
