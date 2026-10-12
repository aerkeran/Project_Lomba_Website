@props([
    'level',
    'activity',
    'label',
    'icon',
    'heading',
    'progressLabel',
    'total',
    'items',
    'menuUrl',
    'showPrev' => true,
    'showNext' => true,
])

@php
    // The quiz hides Next until the answer is right, so it ships hidden and
    // lesson.js simply lifts the class off it.
    $nextClasses = trim(($showPrev ? 'flex-1' : 'w-full').' '.($showNext ? '' : 'hidden'));
@endphp

{{--
    Shared frame for Materi, Latihan and Kuis (PRD §6.5–§6.7).

    Every word of the level ships in the hidden list below: lesson.js walks it
    so a child moves between words without waiting for a page reload. The audio
    button lives in the slot because its position differs per activity, and it
    keeps working through audio-button.js's document-level listener.
--}}
<div
    data-lesson
    data-activity="{{ $activity }}"
    data-menu-url="{{ $menuUrl }}"
    {{ $attributes->merge(['class' => 'flex flex-col gap-6']) }}
>
    <ol data-lesson-items class="hidden">
        @foreach ($items as $item)
            <li
                data-item
                data-english="{{ $item['english'] }}"
                data-indonesia="{{ $item['indonesia'] }}"
                data-image="{{ asset('images/vocab/'.$item['image']) }}"
            ></li>
        @endforeach
    </ol>

    <x-back-button :href="$menuUrl" />

    <header class="flex flex-col items-center gap-1 text-center">
        <p class="text-sm font-bold uppercase tracking-wider text-ink-muted">
            <span aria-hidden="true">{{ $icon }}</span>
            Level {{ $level }} · {{ $label }}
        </p>

        <h1 class="font-display text-3xl font-extrabold sm:text-4xl">{{ $heading }}</h1>
    </header>

    <x-progress-bar :value="1" :max="$total" :label="$progressLabel" data-lesson-progress />

    <x-card padding="lg">
        {{ $slot }}
    </x-card>

    <nav aria-label="Lesson navigation" class="flex items-center gap-3">
        @if ($showPrev)
            <x-button data-lesson-prev variant="ghost" class="flex-1">
                <span aria-hidden="true">←</span> Previous
            </x-button>
        @endif

        <x-button data-lesson-next size="lg" :class="$nextClasses">
            <span data-lesson-next-label>Next</span>
            <span data-lesson-next-emoji aria-hidden="true" class="hidden">🎉</span>
            <span aria-hidden="true">→</span>
        </x-button>
    </nav>
</div>
