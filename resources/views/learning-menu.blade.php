@extends('layouts.app')

@section('title', 'Level '.$level.' — SpeakFun!')

{{-- PRD §6.4 — Learning Menu: three big choices, nothing else competing for attention. --}}
@section('content')
    <x-back-button :href="route('levels')" />

    <header class="flex flex-col gap-2 text-center">
        <p class="text-base font-bold uppercase tracking-wide text-ink-muted">Level {{ $level }}</p>

        <h1 class="font-display text-3xl font-extrabold sm:text-4xl">What do you want to do?</h1>
    </header>

    <nav aria-label="Activities">
        <ul class="flex flex-col gap-4">
            @foreach ($activities as $slug => $activity)
                <li>
                    <x-button :href="route('activity.show', [$level, $slug])" size="lg" class="w-full">
                        <span class="text-2xl" aria-hidden="true">{{ $activity['icon'] }}</span>
                        {{ $activity['label'] }}
                    </x-button>
                </li>
            @endforeach
        </ul>
    </nav>
@endsection
