<?php

namespace App\Http\Controllers;

use App\Services\TtsService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TtsController extends Controller
{
    public function __construct(private readonly TtsService $tts) {}

    /**
     * Serve a synthesised pronunciation for the audio buttons.
     *
     * Keeping the provider call here is what stops the VoiceRSS key from ever
     * reaching a child's browser. Failures answer 503 so the front-end can fall
     * back to the Web Speech API instead of showing a technical error.
     */
    public function __invoke(Request $request): BinaryFileResponse
    {
        $validated = $request->validate([
            'text' => ['required', 'string', 'min:1', 'max:64', 'regex:/^[A-Za-z0-9\s\-\'.]+$/'],
            'language' => ['nullable', 'string', 'max:8'],
        ]);

        $path = $this->tts->synthesize($validated['text'], $validated['language'] ?? null);

        abort_unless($path !== null, 503, 'Audio is not available right now.');

        return response()->file($path, [
            'Content-Type' => 'audio/mpeg',
            // Pronunciations never change, so browsers may reuse them freely.
            'Cache-Control' => 'public, max-age=604800',
        ]);
    }
}
