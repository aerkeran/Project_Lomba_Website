@extends('layouts.app')

@section('title', $title.' — SpeakFun!')

{{--
    Placeholder destination for the three activities (PRD §6.4). The real lessons
    arrive in Fase 3; until then this uses the empty state from DESIGN.md §26 so
    the navigation is never a dead end.
--}}
@section('content')
    <x-back-button :href="route('levels.show', $level)" />

    <header class="flex flex-col items-center gap-3 text-center">
        <span class="text-5xl" aria-hidden="true">{{ $icon }}</span>

        <h1 class="font-display text-3xl font-extrabold">{{ $title }}</h1>

        <p class="text-base font-bold text-ink-muted">Level {{ $level }}</p>
    </header>

    <x-card class="text-center">
        <p class="text-lg font-bold text-ink">No lessons yet.</p>
        <p class="text-base text-ink-secondary">Your next lesson will appear here soon.</p>
    </x-card>
@endsection
