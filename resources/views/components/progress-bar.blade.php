@props([
    'value' => 0,
    'max' => 10,
    'label' => null,
])

@php
    $max = max(1, (int) $max);
    $value = min($max, max(0, (int) $value));
    $percent = round(($value / $max) * 100);
    $accessibleLabel = $label ?? 'Progress';
@endphp

<div {{ $attributes->merge(['class' => 'w-full']) }}>
    @if ($label)
        <div class="mb-2 flex items-baseline justify-between gap-4 text-sm font-bold text-ink-secondary">
            <span>{{ $label }}</span>
            <span>{{ $value }} / {{ $max }}</span>
        </div>
    @endif

    <div
        role="progressbar"
        aria-label="{{ $accessibleLabel }}"
        aria-valuemin="0"
        aria-valuemax="{{ $max }}"
        aria-valuenow="{{ $value }}"
        class="h-3 w-full overflow-hidden rounded-pill bg-line"
    >
        <div
            class="h-full rounded-pill bg-primary transition-[width] duration-300 ease-out"
            style="width: {{ $percent }}%"
        ></div>
    </div>
</div>
