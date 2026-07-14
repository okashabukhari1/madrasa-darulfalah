<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Monthly fee dues generation (runs on 1st day of every month at 01:10)
app()->booted(function () {
    app(Schedule::class)
        ->command('fees:generate-monthly-dues')
        ->monthlyOn(1, '01:10')
        ->withoutOverlapping()
        ->onOneServer();
});
