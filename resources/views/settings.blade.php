@extends('layouts.app')

@section('title', 'Settings — SpeakFun!')

{{-- PRD §6.2 — Settings holds the volume slider and nothing else. --}}
@section('content')
    <x-back-button :href="route('home')" />

    <div class="flex flex-col gap-6">
        <h1 class="font-display text-3xl font-extrabold">Settings</h1>

        <x-card>
            <x-volume-slider />
        </x-card>
    </div>
@endsection
