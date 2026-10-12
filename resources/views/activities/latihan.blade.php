@extends('layouts.app')

@section('title', 'Latihan — Level '.$level.' — SpeakFun!')

{{--
    Latihan (PRD §6.6 / FR-05): listen and copy the pronunciation. There is
    deliberately no microphone — the workshop has no voice recognition, and a
    button that records without ever answering would only confuse a child.
--}}
@php($first = $items->first())

@section('content')
    <x-lesson-shell
        :level="$level"
        activity="latihan"
        :label="$label"
        :icon="$icon"
        heading="Listen & Repeat"
        progress-label="Word"
        :total="$total"
        :items="$items"
        :menu-url="$menuUrl"
    >
        <figure class="flex flex-col items-center gap-5 text-center">
            <p class="text-lg font-bold text-ink-secondary">Say this word:</p>

            <img
                data-lesson-image
                src="{{ asset('images/vocab/'.$first['image']) }}"
                alt="{{ $first['english'] }}"
                width="400"
                height="400"
                class="aspect-square w-52 max-w-full rounded-xl object-contain sm:w-64"
            >

            <p data-lesson-word class="font-display text-4xl font-extrabold uppercase text-primary sm:text-5xl">
                {{ ucfirst($first['english']) }}
            </p>

            <x-audio-button
                data-lesson-audio
                :text="$first['english']"
                label="Listen"
                size="lg"
            />

            <p class="rounded-pill bg-secondary-soft px-4 py-2 text-sm font-bold text-ink">
                Now it's your turn!
            </p>
        </figure>
    </x-lesson-shell>
@endsection
