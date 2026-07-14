<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Fee extends Model
{
    use HasFactory;

    public const PAYMENT_TYPES = ['Khalis', 'Zakat', 'Hadiya', 'Sadqa', 'Fitra', 'Fidya', 'Others'];

    protected $fillable = [
        'student_id',
        'teacher_id',
        'name',
        'phone',
        'amount',
        'payment_type',
        'status',
        'check_no',
        'bank',
        'payment_date',
        'reference_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'teacher_id');
    }

    public static function generateReferenceId(?int $year = null): string
    {
        $year = $year ?? (int) now()->format('Y');

        return DB::transaction(function () use ($year) {
            // Lock latest row to avoid duplicate reference IDs under concurrency.
            $last = self::query()
                ->whereYear('payment_date', $year)
                ->lockForUpdate()
                ->latest('id')
                ->value('reference_id');

            $next = 1;
            if ($last && preg_match('/^MDF\-' . $year . '\-(\d{4})$/', $last, $m)) {
                $next = ((int) $m[1]) + 1;
            }

            return 'MDF-' . $year . '-' . str_pad((string) $next, 4, '0', STR_PAD_LEFT);
        });
    }
}

