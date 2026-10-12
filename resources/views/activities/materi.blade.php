@extends('layouts.app')

@section('title', 'Materi — Level '.$level.' — SpeakFun!')

{{--
    Materi (PRD §6.5 / FR-04): picture, English word, pronunciation on tap,
    then move on. The Indonesian word sits under it as a small caption — the
    Indonesian-to-English pairing is the whole point of SpeakFun! (PRD §1).
--}}
@php($first = $items->first())

@section('content')
    <x-lesson-shell
        :level="$level"
        activity="materi"
        :label="$label"
        :icon="$icon"
        heading="Let's Learn!"
        progress-label="Word"
        :total="$total"
        :items="$items"
        :menu-url="$menuUrl"
    >
        <figure class="flex flex-col items-center gap-5 text-center">
            <img
                data-lesson-image
                src="{{ asset('images/vocab/'.$first['image']) }}"
                alt="{{ $first['english'] }}"
                width="400"
                height="400"
                class="aspect-square w-52 max-w-full rounded-xl object-contain sm:w-64"
            >

            <figcaption class="flex flex-col gap-1">
                <p data-lesson-word class="font-display text-4xl font-extrabold text-primary sm:text-5xl">
                    {{ ucfirst($first['english']) }}
                </p>

                <p data-lesson-caption class="text-base font-bold text-ink-secondary">{{ $first['indonesia'] }}</p>
            </figcaption>

            <x-audio-button
                data-lesson-audio
                :text="$first['english']"
                label="Play"
                done-label="Play Again"
                size="lg"
            />
        </figure>
    </x-lesson-shell>
@endsection
