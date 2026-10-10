@props([
    'href' => '/',
    'label' => 'Back',
])

@php
    $classes = 'inline-flex min-h-11 items-center gap-2 rounded-md px-2 text-base font-bold text-ink-secondary transition hover:bg-ink/5 hover:text-ink focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary/40';
@endphp

<a {{ $attributes->merge(['href' => $href, 'class' => $classes]) }}>
    <span aria-hidden="true">←</span> {{ $label }}
</a>
