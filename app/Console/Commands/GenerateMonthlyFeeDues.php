<?php

namespace App\Console\Commands;

use App\Models\FeePlan;
use App\Models\Student;
use App\Models\StudentFeeDue;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateMonthlyFeeDues extends Command
{
    protected $signature = 'fees:generate-monthly-dues {--year=} {--month=} {--dry-run}';
    protected $description = 'Generate monthly fee dues for active students (idempotent).';

    public function handle(): int
    {
        $year = (int) ($this->option('year') ?: now()->format('Y'));
        $month = (int) ($this->option('month') ?: now()->format('m'));
        $dryRun = (bool) $this->option('dry-run');

        if ($month < 1 || $month > 12) {
            $this->error('Month must be between 1 and 12.');
            return self::FAILURE;
        }

        $plans = FeePlan::query()->where('is_active', true)->get();
        if ($plans->isEmpty()) {
            $this->warn('No active fee plans found. Nothing to generate.');
            return self::SUCCESS;
        }

        $dueDate = now()->setYear($year)->setMonth($month)->startOfMonth()->addDays(9)->toDateString();

        $created = 0;
        $skipped = 0;

        Student::query()
            ->with(['courses'])
            ->where('status', 'active')
            ->orderBy('id')
            ->chunkById(200, function ($students) use ($plans, $year, $month, $dueDate, $dryRun, &$created, &$skipped) {
                foreach ($students as $student) {
                    $exists = StudentFeeDue::query()
                        ->where('student_id', $student->id)
                        ->where('year', $year)
                        ->where('month', $month)
                        ->exists();

                    if ($exists) {
                        $skipped++;
                        continue;
                    }

                    $plan = $this->matchPlan($plans, $student);
                    if (!$plan) {
                        $skipped++;
                        continue;
                    }

                    if ($dryRun) {
                        $created++;
                        continue;
                    }

                    DB::transaction(function () use ($student, $plan, $year, $month, $dueDate, &$created) {
                        // Double-check inside transaction (race-safe)
                        $exists2 = StudentFeeDue::query()
                            ->where('student_id', $student->id)
                            ->where('year', $year)
                            ->where('month', $month)
                            ->exists();
                        if ($exists2) {
                            return;
                        }

                        StudentFeeDue::create([
                            'student_id' => $student->id,
                            'fee_plan_id' => $plan->id,
                            'year' => $year,
                            'month' => $month,
                            'amount' => $plan->monthly_amount,
                            'status' => 'due',
                            'due_date' => $dueDate,
                            'generated_at' => now(),
                        ]);
                        $created++;
                    });
                }
            });

        $this->info("Monthly dues generation complete. Created: {$created}, Skipped: {$skipped} (year={$year}, month={$month})." . ($dryRun ? ' [dry-run]' : ''));
        return self::SUCCESS;
    }

    private function matchPlan($plans, Student $student): ?FeePlan
    {
        // Priority: exact match (program+class+course) → program+class → program → fallback (all null)
        $studentCourseIds = $student->courses?->pluck('id')->all() ?? [];

        $candidates = $plans->filter(function (FeePlan $plan) use ($student, $studentCourseIds) {
            if ($plan->program && $plan->program !== $student->program) return false;
            if ($plan->class && $plan->class !== $student->class) return false;
            if ($plan->course_id && !in_array($plan->course_id, $studentCourseIds, true)) return false;
            return true;
        });

        if ($candidates->isEmpty()) {
            return null;
        }

        return $candidates
            ->sortByDesc(fn (FeePlan $p) => (int) !is_null($p->course_id) + (int) !is_null($p->class) + (int) !is_null($p->program))
            ->first();
    }
}

