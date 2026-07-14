<?php

use App\Models\Teacher;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('teachers', 'teacher_id')) {
            Schema::table('teachers', function (Blueprint $table) {
                $table->string('teacher_id', 7)->nullable()->unique()->after('id'); // TH00001
            });
        }

        // Backfill existing teachers sequentially (stable by primary key).
        $counter = 1;
        Teacher::query()
            ->orderBy('id')
            ->select(['id', 'teacher_id'])
            ->chunkById(200, function ($teachers) use (&$counter) {
                foreach ($teachers as $teacher) {
                    if (!empty($teacher->teacher_id)) {
                        continue;
                    }
                    $teacher->teacher_id = 'TH' . str_pad((string) $counter, 5, '0', STR_PAD_LEFT);
                    $teacher->save();
                    $counter++;
                }
            });
    }

    public function down(): void
    {
        if (Schema::hasColumn('teachers', 'teacher_id')) {
            Schema::table('teachers', function (Blueprint $table) {
                // Best-effort cleanup (index name may vary across environments).
                try { $table->dropUnique(['teacher_id']); } catch (\Throwable $e) {}
                $table->dropColumn('teacher_id');
            });
        }
    }
};

