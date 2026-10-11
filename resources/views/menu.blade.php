@extends('layouts.app')

@section('title', 'SpeakFun! — Listen, Speak, Learn!')

{{-- PRD §6.1 — Menu Screen: the first thing a child sees. --}}
@section('content')
    <div class="flex flex-1 flex-col items-center justify-center gap-8 py-6 text-center">
        <header class="flex flex-col items-center gap-4">
            <div
                class="flex h-24 w-24 items-center justify-center rounded-hero bg-primary-soft text-5xl shadow-soft"
                aria-hidden="true"
            >
                🔊
            </div>

            <div class="flex flex-col gap-1">
                <h1 class="font-display text-4xl font-extrabold text-primary sm:text-5xl">
                    SpeakFun!
                </h1>

                <p class="text-lg font-bold text-ink-secondary">Listen, Speak, Learn!</p>
            </div>
        </header>

        <div class="flex w-full max-w-xs flex-col gap-3">
            <x-button :href="route('levels')" size="lg" class="w-full">
                <span aria-hidden="true">▶</span> Play
            </x-button>

            <x-button :href="route('settings')" variant="secondary" class="w-full">
                <span aria-hidden="true">⚙</span> Settings
            </x-button>
        </div>

        <x-volume-slider class="max-w-xs" />
    </div>
@endsection
