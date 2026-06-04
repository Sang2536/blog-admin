@props(['color' => 'gray'])

@php
    $baseClass = 'inline-flex rounded-full px-2 text-xs font-semibold leading-5';
    $colorClass = $color
        ? `bg-$color-100 text-$color-800 dark:bg-$color-900 dark:text-$color-300`
        : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
@endphp

<span class="{{ $baseClass }} {{ $colorClass }}">
    {{ $slot }}
</span>
