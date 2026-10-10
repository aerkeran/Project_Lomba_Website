@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'type' => 'button',
    'disabled' => false,
])

@php
    $tag = $href === null ? 'button' : 'a';
    $classes = 'btn btn--'.($variant ?: 'primary').' btn--'.($size ?: 'md');
@endphp

<{{ $tag }}
    @if ($href === null) type="{{ $type }}" @else href="{{ $href }}" @endif
    @if ($href === null && $disabled) disabled @endif
    {{ $attributes->merge(['class' => $classes]) }}
>{{ $slot }}</{{ $tag }}>
