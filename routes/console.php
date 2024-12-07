<?php

use App\Console\Commands\UpdatePoolStats;
use App\Console\Commands\UpdateTokenHolders;
use App\Console\Commands\UpdateTradeCandles;
use App\Services\Rate;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

//schedule
Schedule::command(UpdatePoolStats::class)->everyTenMinutes();
Schedule::command(UpdateTokenHolders::class)->hourly();
Schedule::command(UpdateTradeCandles::class, ['--days=1'])->hourly();
Schedule::command(UpdateTradeCandles::class, ['--days=30'])->daily();
//commands
Artisan::command('rates:update', function () {
    Rate::update();
})->purpose('Update crypto rates in the db')->hourly();

//utility
Artisan::command('lang:strap', function () {
    Artisan::call('translatable:export', ['lang' => 'en']);
    Artisan::call('vue-i18n:generate', ['--with-vendor' => 'en']);
});
