<?php

use App\Console\Commands\MarkAbsent;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('attendance:check')->dailyAt('22:00');
// Schedule::command(MarkAbsent::class)->everySecond();