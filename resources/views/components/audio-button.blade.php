@props([
    'text',
    'label' => 'Listen',
    'doneLabel' => null,
    'variant' => 'primary',
    'size' => 'md',
])

@php
    $doneLabel ??= $label.' Again';
@endphp

{{--
    The pronunciation button (DESIGN.md §17). It never talks to the speech
    provider directly: resources/js/features/tts.js asks the /tts route and
    falls back to the browser's Web Speech API when that fails.
--}}
<button
    type="button"
    data-audio-button
    data-state="idle"
    data-text="{{ $text }}"
    data-label-idle="{{ $label }}"
    data-label-loading="Loading..."
    data-label-speaking="Speaking..."
    data-label-done="{{ $doneLabel }}"
    data-label-error="Try again"
    {{ $attributes->merge(['class' => 'btn btn--'.($variant ?: 'primary').' btn--'.($size ?: 'md')]) }}
>
    <span class="sf-audio-button__icon" aria-hidden="true">🔊</span>
    <span class="sf-audio-button__label" aria-live="polite">{{ $label }}</span>
</button>
