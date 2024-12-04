<?php

use App\Http\Controllers\LaunchpadsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\S3Controller;
use App\Http\Controllers\TradesController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::controller(S3Controller::class)
    ->group(function () {
        Route::post('sign/{disk?}/{folder?}', 'sign')->name('s3.sign');
    });


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__ . '/otp.php';
require __DIR__ . '/web3.php';



#launchpads
Route::name('launchpads.')->controller(LaunchpadsController::class)->group(function () {
    Route::get('/launchpads', 'index')->name('index');
    Route::get('/launch', 'create')->name('create');
    Route::post('/launchpads/store', 'store')->name('store');
    Route::get('/{launchpad:contract}', 'show')
        ->where('launchpad', '0x[a-fA-F0-9]{40}')
        ->name('show');
    Route::put('/launchpads/{launchpad}', 'update')->name('update');
});
#launchpads





#msgs
Route::name('msgs')->controller(MsgsController::class)->group(function () {
    Route::get('/msgs', 'index')->name('index');
    Route::get('/msgs/create', 'create')->name('create');
    Route::post('/msgs/store', 'store')->name('store');
    Route::get('/msgs/{msg}/show', 'show')->name('show');
    Route::get('/msgs/{msg}/edit', 'edit')->name('edit');
    Route::put('/msgs/{msg}', 'update')->name('update');
    Route::put('/msgs/toggle/{msg}', 'toggle')->name('toggle');
    Route::delete('/msgs/{msg}', 'destroy')->name('destroy');
});
#msgs



// API endpoints for tradingview charting library
Route::prefix('api')->group(function () {
    Route::get('/launchpad/{launchpad}/candles', [TradesController::class, 'getCandles']);
    Route::get('/launchpad/{launchpad}/trades', [TradesController::class, 'getRecentTrades']);
    Route::get('/launchpad/{launchpad}/stats', [TradesController::class, 'getPriceStats']);
});

#trades
Route::name('trades.')->controller(TradesController::class)->group(function () {
    Route::post('/trades/store', 'store')->name('store');
});
#trades

#rates
 Route::name('rates')->controller(RatesController::class)->group(function () {
    Route::get('/rates', 'index')->name('index');
    Route::get('/rates/create', 'create')->name('create');
    Route::post('/rates/store', 'store')->name('store');
    Route::get('/rates/{rate}/show', 'show')->name('show');
    Route::get('/rates/{rate}/edit', 'edit')->name('edit');
    Route::put('/rates/{rate}', 'update')->name('update');
    Route::put('/rates/toggle/{rate}', 'toggle')->name('toggle');
    Route::delete('/rates/{rate}', 'destroy')->name('destroy');
});
#rates