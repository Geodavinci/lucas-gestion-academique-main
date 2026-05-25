@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-3 pt-1 pb-1 border-b-2 border-blue-600 text-sm font-medium text-gray-900 focus:outline-none focus:border-blue-700 transition-colors duration-200'
            : 'inline-flex items-center px-3 pt-1 pb-1 border-b-2 border-transparent text-sm font-medium text-gray-600 hover:text-gray-900 hover:border-gray-300 focus:outline-none focus:text-gray-900 transition-colors duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
