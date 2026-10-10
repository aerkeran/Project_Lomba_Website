<?php

use App\Http\Controllers\TtsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/*
 * Pronunciation audio for the TTS buttons. Throttled so a runaway client
 * cannot burn the daily VoiceRSS quota before the children get a turn.
 */
Route::get('/tts', TtsController::class)
    ->name('tts')
    ->middleware('throttle:60,1');
