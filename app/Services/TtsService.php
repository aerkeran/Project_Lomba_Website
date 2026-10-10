<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Factory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

/**
 * Text-to-speech through VoiceRSS, with an on-disk cache so the limited daily
 * quota is only spent once per pronunciation.
 *
 * The API key stays on the server; browsers call the /tts route instead of the
 * provider directly. When synthesis is impossible (no key, quota exhausted,
 * offline) the client falls back to the browser's Web Speech API.
 */
class TtsService
{
    public function __construct(private readonly Factory $http) {}

    /**
     * Absolute path of the synthesised MP3 for the given text, or null when the
     * audio could not be produced.
     */
    public function synthesize(string $text, ?string $language = null): ?string
    {
        $language = $language ?: (string) config('tts.voicerss.language');
        $relativePath = $this->cachePath($text, $language);

        if (Storage::disk('local')->exists($relativePath)) {
            return Storage::disk('local')->path($relativePath);
        }

        $key = (string) config('tts.voicerss.key');

        if ($key === '') {
            return null;
        }

        $audio = $this->requestAudio($key, $text, $language);

        if ($audio === null) {
            return null;
        }

        Storage::disk('local')->put($relativePath, $audio);

        return Storage::disk('local')->path($relativePath);
    }

    /**
     * Cache location inside the local disk root, e.g. tts-cache/5f2a….mp3.
     */
    public function cachePath(string $text, string $language): string
    {
        return trim((string) config('tts.cache_path'), '/').'/'.sha1(mb_strtolower($language).'|'.$text).'.mp3';
    }

    /**
     * Ask VoiceRSS for a single pronunciation. Returns null on any failure so
     * the caller can degrade instead of surfacing a technical error to a child.
     */
    private function requestAudio(string $key, string $text, string $language): ?string
    {
        try {
            // $throw = false keeps non-2xx answers in our hands: VoiceRSS reports
            // bad keys and exhausted quotas as plain 4xx, which the caller must
            // turn into "use the browser fallback" rather than an exception.
            $response = $this->http
                ->connectTimeout(3)
                ->timeout((int) config('tts.voicerss.timeout'))
                ->retry(
                    2,
                    200,
                    fn (Throwable $exception): bool => $exception instanceof ConnectionException,
                    throw: false,
                )
                ->get((string) config('tts.voicerss.endpoint'), [
                    'key' => $key,
                    'src' => $text,
                    'hl' => $language,
                    'c' => 'mp3',
                    'r' => 0,
                ]);
        } catch (ConnectionException $exception) {
            Log::warning('VoiceRSS unreachable: '.$exception->getMessage());

            return null;
        }

        $body = $response->body();

        // VoiceRSS reports problems as plain text, never as MP3 bytes.
        if (! $response->successful() || ! $this->looksLikeMp3($body)) {
            Log::warning('VoiceRSS returned no audio.', [
                'status' => $response->status(),
                'response' => mb_substr($body, 0, 200),
            ]);

            return null;
        }

        return $body;
    }

    /**
     * MP3 starts with an "ID3" tag or with a frame sync of 0xFF 0xEx.
     */
    private function looksLikeMp3(string $body): bool
    {
        if (str_starts_with($body, 'ID3')) {
            return true;
        }

        return strlen($body) >= 2
            && ord($body[0]) === 0xFF
            && (ord($body[1]) & 0xE0) === 0xE0;
    }
}
