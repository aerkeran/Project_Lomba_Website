<?php

use App\Http\Controllers\LevelController;
use App\Http\Controllers\TtsController;
use Illuminate\Support\Facades\Route;

// PRD §6.1 — the start screen.
Route::view('/', 'menu')->name('home');

// PRD §6.2 — volume is the only setting.
Route::view('/settings', 'settings')->name('settings');

// PRD §6.3 / §6.4 — level picker, then the learning menu of one level.
Route::get('/levels', [LevelController::class, 'index'])
    ->name('levels');

Route::get('/levels/{level}', [LevelController::class, 'show'])
    ->whereNumber('level')
    ->name('levels.show');

/*
 * Materi / Latihan / Kuis (PRD §6.4). The lesson content arrives in Fase 3, but
 * the routes exist now so FR-01 navigation is complete and testable today.
 */
Route::get('/levels/{level}/{activity}', [LevelController::class, 'activity'])
    ->whereNumber('level')
    ->whereIn('activity', ['materi', 'latihan', 'kuis'])
    ->name('activity.show');

/*
 * Pronunciation audio for the TTS buttons. Throttled so a runaway client
 * cannot burn the daily VoiceRSS quota before the children get a turn.
 */
Route::get('/tts', TtsController::class)
    ->name('tts')
    ->middleware('throttle:60,1');
