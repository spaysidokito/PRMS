<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ResourceController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('student-profiles', StudentProfileController::class);
    Route::resource('events', EventController::class);

    Route::get('/resources', function () {
        return view('resources.index');
    })->name('resources.index');

    // Resource Management Routes
    Route::prefix('resources')->name('resources.')->group(function () {
        Route::get('/soa', [App\Http\Controllers\ResourceController::class, 'soa'])->name('soa');
        Route::get('/gtc', [App\Http\Controllers\ResourceController::class, 'gtc'])->name('gtc');
        Route::get('/pod', [App\Http\Controllers\ResourceController::class, 'pod'])->name('pod');

        Route::post('/soa/store', [App\Http\Controllers\ResourceController::class, 'soaStore'])->name('soa.store');
        Route::post('/gtc/store', [App\Http\Controllers\ResourceController::class, 'gtcStore'])->name('gtc.store');
        Route::post('/pod/store', [App\Http\Controllers\ResourceController::class, 'podStore'])->name('pod.store');

        Route::get('/soa/download', [App\Http\Controllers\ResourceController::class, 'soaDownload'])->name('soa.download');
        Route::get('/gtc/download', [App\Http\Controllers\ResourceController::class, 'gtcDownload'])->name('gtc.download');
        Route::get('/pod/download', [App\Http\Controllers\ResourceController::class, 'podDownload'])->name('pod.download');

        Route::get('/soa/print', [App\Http\Controllers\ResourceController::class, 'soaPrint'])->name('soa.print');
        Route::get('/gtc/print', [App\Http\Controllers\ResourceController::class, 'gtcPrint'])->name('gtc.print');
        Route::get('/pod/print', [App\Http\Controllers\ResourceController::class, 'podPrint'])->name('pod.print');
    });

    Route::get('/users', function () {
        return view('users.index');
    })->name('users.index');
});
