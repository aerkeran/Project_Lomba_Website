@extends('layouts.app')

@section('title', 'Choose Your Level! — SpeakFun!')

{{-- PRD §6.3 — one button per class: single column on mobile, grid on desktop (PRD §10). --}}
@section('content')
    <x-back-button :href="route('home')" />

    <header class="text-center">
        <h1 class="font-display text-3xl font-extrabold sm:text-4xl">Choose Your Level!</h1>
    </header>

    <ul class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($levels as $level)
            <li>
                <x-button :href="route('levels.show', $level)" variant="secondary" size="lg" class="w-full">
                    Level {{ $level }}
                </x-button>
            </li>
        @endforeach
    </ul>
@endsection
