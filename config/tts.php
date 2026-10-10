<?php

return [

    /*
    |--------------------------------------------------------------------------
    | VoiceRSS
    |--------------------------------------------------------------------------
    |
    | VoiceRSS performs the English pronunciation for SpeakFun!. The key is read
    | from the environment and only ever used server-side: children's browsers
    | ask the /tts route for audio instead of calling the provider themselves.
    |
    */

    'voicerss' => [

        'key' => env('VOICERSS_KEY'),

        'endpoint' => env('VOICERSS_ENDPOINT', 'https://api.voicerss.org/'),

        // The site teaches English, so every pronunciation is read in English.
        'language' => env('VOICERSS_LANGUAGE', 'en-us'),

        'timeout' => (int) env('VOICERSS_TIMEOUT', 8),

    ],

    // Folder on the local disk that holds the synthesised MP3 files.
    'cache_path' => env('TTS_CACHE_PATH', 'tts-cache'),

];
