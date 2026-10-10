@props([
    'state' => 'success',
    'title' => '',
    'message' => null,
    'icon' => null,
])

@php
    // A wrong answer never gets a red punishment face — DESIGN.md §19 keeps it encouraging.
    $icons = ['success' => '🎉', 'error' => '😊', 'info' => '💡'];
    $skins = [
        'success' => 'border-success/40 bg-success-soft',
        'error' => 'border-error/40 bg-error-soft',
        'info' => 'border-primary/30 bg-primary-soft',
    ];
    $icon = $icon ?? ($icons[$state] ?? $icons['info']);
    $skin = $skins[$state] ?? $skins['info'];
@endphp

<div
    {{ $attributes->merge([
        'class' => 'flex items-start gap-3 rounded-card border p-4 sm:p-5 '.$skin,
        'role' => $state === 'error' ? 'alert' : 'status',
    ]) }}
>
    <span class="text-2xl leading-none" aria-hidden="true">{{ $icon }}</span>

    <div class="min-w-0">
        <p class="text-lg font-extrabold text-ink">{{ $title }}</p>

        @if ($message)
            <p class="text-base text-ink-secondary">{{ $message }}</p>
        @endif
    </div>
</div>
