<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Resize to TH0000001 (2 + 7 digits = 9 chars) without requiring doctrine/dbal.
        if (Schema::hasColumn('teachers', 'teacher_id')) {
            DB::statement("ALTER TABLE teachers MODIFY teacher_id VARCHAR(9) NULL");
        }
        if (Schema::hasColumn('fees', 'teacher_id')) {
            DB::statement("ALTER TABLE fees MODIFY teacher_id VARCHAR(9) NULL");
        }

        // Normalize teacher IDs to 7-digit padding: TH0000001
        if (Schema::hasColumn('teachers', 'teacher_id')) {
            DB::statement("
                UPDATE teachers
                SET teacher_id = CONCAT('TH', LPAD(CAST(SUBSTRING(teacher_id, 3) AS UNSIGNED), 7, '0'))
                WHERE teacher_id IS NOT NULL AND teacher_id REGEXP '^TH[0-9]+$'
            ");
        }

        // Normalize fees.teacher_id the same way (since it stores teacher_id string)
        if (Schema::hasColumn('fees', 'teacher_id')) {
            DB::statement("
                UPDATE fees
                SET teacher_id = CONCAT('TH', LPAD(CAST(SUBSTRING(teacher_id, 3) AS UNSIGNED), 7, '0'))
                WHERE teacher_id IS NOT NULL AND teacher_id REGEXP '^TH[0-9]+$'
            ");
        }
    }

    public function down(): void
    {
        // No down conversion; keeping longer IDs is safe.
    }
};

