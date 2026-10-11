@props([
    'label' => 'Volume',
    'id' => 'sf-volume',
])

{{--
    Volume control (PRD FR-08). The same markup works on the start screen and in
    Settings: resources/js/features/volume.js seeds it from localStorage and
    keeps every slider on the page in sync.
--}}
<div {{ $attributes->merge(['data-volume-group' => '', 'class' => 'w-full']) }}>
    <div class="flex items-center justify-between gap-4">
        <label for="{{ $id }}" class="flex items-center gap-2 text-base font-bold text-ink">
            <span aria-hidden="true">🔊</span> {{ $label }}
        </label>

        <output for="{{ $id }}" data-volume-output class="text-base font-bold text-ink-secondary tabular-nums">100%</output>
    </div>

    {{-- h-11 keeps the slider on the 44px touch target (DESIGN.md §29). --}}
    <input
        id="{{ $id }}"
        type="range"
        min="0"
        max="100"
        step="1"
        data-volume-slider
        class="h-11 w-full cursor-pointer accent-primary"
    >
</div>
