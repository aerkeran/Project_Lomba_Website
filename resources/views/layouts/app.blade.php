<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', 'SpeakFun! — Listen, Speak, Learn!')</title>

        @fonts

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        @stack('head')
    </head>

    <body
        class="min-h-screen bg-canvas font-sans text-ink antialiased"
        data-tts-url="{{ route('tts') }}"
    >
        <a
            href="#main-content"
            class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-50 focus:rounded-md focus:bg-primary focus:px-4 focus:py-2 focus:font-bold focus:text-white"
        >
            Skip to content
        </a>

        <div class="mx-auto flex w-full max-w-3xl flex-col gap-6 px-4 py-6 sm:px-6 lg:px-8">
            <main id="main-content" class="flex flex-1 flex-col gap-6">
                @yield('content')
            </main>
        </div>

        {{--
            TTS problems are announced politely instead of interrupting the child
            with a browser error (DESIGN.md §24). Hidden while it has nothing to say.
        --}}
        <div
            id="sf-tts-status"
            role="status"
            aria-live="polite"
            class="pointer-events-none fixed inset-x-4 bottom-4 z-50 mx-auto w-fit max-w-md rounded-card border border-error/40 bg-error-soft px-4 py-3 text-center text-base font-bold text-ink shadow-card empty:hidden"
        ></div>

        @stack('scripts')
    </body>
</html>
