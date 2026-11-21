<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminEventController;

// Public Event Routes
Route::get('/', [EventController::class, 'index'])->name('events.index');
Route::get('/jadwal', [EventController::class, 'schedule'])->name('events.schedule');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('/events/{event}/poster', [EventController::class, 'poster'])->name('events.poster');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Event Rutes. Middleware authentication dan peran ditambahkan Bekti
Route::prefix('admin')->name('admin.')->group(function() {
    Route::resource('events', AdminEventController::class)->except(['show']);
});
