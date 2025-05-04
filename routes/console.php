<?php

use App\Console\Commands\MarkAbsent;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function() {
    logger("kontol");
})->everySecond();

// Schedule::command(MarkAbsent::class)->everySecond();