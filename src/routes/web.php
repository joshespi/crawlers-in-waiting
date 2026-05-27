<?php

use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\RssController;
use App\Http\Controllers\Admin\EpisodeController as AdminEpisodeController;
use Illuminate\Support\Facades\Route;

// Public
Route::get('/', [EpisodeController::class, 'index'])->name('home');
Route::get('/episodes/{episode:slug}', [EpisodeController::class, 'show'])->name('episodes.show');
Route::get('/about', fn () => view('about'))->name('about');
Route::get('/feed.rss', RssController::class)->name('rss');

// Auth
Route::get('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store'])->middleware('throttle:5,1');
Route::post('/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Admin
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', fn () => redirect()->route('admin.episodes.index'));
    Route::resource('episodes', AdminEpisodeController::class);
});
