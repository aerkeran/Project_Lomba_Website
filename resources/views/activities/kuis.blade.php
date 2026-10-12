@extends('layouts.app')

@section('title', 'Kuis — Level '.$level.' — SpeakFun!')

{{--
    Kuis (PRD §6.7, FR-06, FR-07): hear the word, type it, press Check.

    lesson.js compares the answer the moment Check is pressed. Keeping the check
    in the browser gives a child the immediate answer DESIGN.md §36 Principle 2
    asks for, and a round trip to the dev server would put a visible pause on
    every single word. Nothing is at stake — the workshop has no accounts, no
    score board and no ranking (PRD §13), so the words being readable in the
    page costs nothing.
--}}
@php($first = $items->first())

@section('content')
    <x-lesson-shell
        :level="$level"
        activity="kuis"
        :label="$label"
        :icon="$icon"
        heading="What is this in English?"
        progress-label="Question"
        :total="$total"
        :items="$items"
        :menu-url="$menuUrl"
        :show-prev="false"
        :show-next="false"
    >
        <div class="flex flex-col items-center gap-5 text-center">
            <img
                data-lesson-image
                src="{{ asset('images/vocab/'.$first['image']) }}"
                alt="{{ $first['english'] }}"
                width="400"
                height="400"
                class="aspect-square w-52 max-w-full rounded-xl object-contain sm:w-64"
            >

            <x-audio-button
                data-lesson-audio
                :text="$first['english']"
                label="Listen"
                size="lg"
            />
        </div>

        <form data-lesson-form class="mt-2 flex flex-col gap-4">
            <div>
                <label for="sf-answer" class="mb-2 block text-base font-bold text-ink">Your answer</label>

                <input
                    id="sf-answer"
                    name="answer"
                    type="text"
                    data-lesson-input
                    placeholder="Type here..."
                    autocomplete="off"
                    autocorrect="off"
                    autocapitalize="off"
                    spellcheck="false"
                    class="h-12 w-full rounded-xl border border-line bg-surface px-4 text-lg font-bold text-ink placeholder:font-normal placeholder:text-ink-muted focus:border-primary focus:outline-none focus:ring-4 focus:ring-primary/40"
                >
            </div>

            {{-- Shown only after a correct answer: DESIGN.md §16 ends with the word itself. --}}
            <p data-lesson-reveal class="hidden font-display text-3xl font-extrabold text-primary"></p>

            <div data-lesson-feedback="correct" class="hidden">
                <x-feedback state="success" title="Great Job!" message="You got it right!" />
            </div>

            <div data-lesson-feedback="wrong" class="hidden">
                <x-feedback state="error" title="Try Again!" message="Listen once more, then type it again." />
            </div>

            <div data-lesson-feedback="prompt" class="hidden">
                <x-feedback state="info" title="Type your answer first." message="Then press Check." />
            </div>

            <x-button type="submit" size="lg" class="w-full">Check</x-button>
        </form>
    </x-lesson-shell>
@endsection
