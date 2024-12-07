<?php

use App\Http\Controllers\LaunchpadsController;
use App\Http\Controllers\MsgsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\S3Controller;
use App\Http\Controllers\TradesController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


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
    Route::get('/{type?}', 'index')->whereIn('type', ['trending', 'top', 'featured', 'rising', 'new', 'finalized', 'mine'])->name('index');
    Route::get('/launch', 'create')->name('create');
    Route::post('/launchpads/store', 'store')->name('store');
    Route::put('/launchpads/finalize/{launchpad}', 'finalize')->name('finalize');
    Route::get('/{launchpad:contract}', 'show')
        ->where('launchpad', '0x[a-fA-F0-9]{40}')
        ->name('show');
    Route::put('/launchpads/{launchpad}', 'update')->name('update');
});
#launchpads

#msgs
Route::name('msgs.')->controller(MsgsController::class)->group(function () {
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


#trades
Route::name('trades.')->controller(TradesController::class)->group(function () {
    Route::post('/trades/store', 'store')->name('store');
    Route::get('/api/launchpad/{launchpad:contract}/candles', 'getCandles')->name('candles');
});
#trades


#promos
 Route::name('promos')->controller(PromosController::class)->group(function () {
    Route::get('/promos', 'index')->name('index');
    Route::get('/promos/create', 'create')->name('create');
    Route::post('/promos/store', 'store')->name('store');
    Route::get('/promos/{promo}/show', 'show')->name('show');
    Route::get('/promos/{promo}/edit', 'edit')->name('edit');
    Route::put('/promos/{promo}', 'update')->name('update');
    Route::put('/promos/toggle/{promo}', 'toggle')->name('toggle');
    Route::delete('/promos/{promo}', 'destroy')->name('destroy');
});
#promos