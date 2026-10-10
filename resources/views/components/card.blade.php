@props([
    'padding' => 'md',
])

@php
    $paddingClasses = match ($padding) {
        'none' => '',
        'sm' => 'p-4',
        'lg' => 'p-6 sm:p-8',
        default => 'p-4 sm:p-6',
    };
@endphp

<div {{ $attributes->merge(['class' => 'rounded-card border border-line bg-surface shadow-soft '.$paddingClasses]) }}>
    {{ $slot }}
</div>
