@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full pl-3 pr-4 py-2 border-l-4 border-purple-600 text-left text-base font-medium text-purple-600 bg-sky-400 focus:outline-none focus:text-purple-600 focus:bg-sky-300 focus:border-purple-600 transition duration-150 ease-in-out'
            : 'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-white hover:bg-sky-400 hover:border-gray-300 focus:outline-none focus:bg-sky-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
