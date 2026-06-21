<?php

use App\Jobs\ProcessDailySalesJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('diss', function () {
dispatch(new ProcessDailySalesJob);
})->everyMinute();
