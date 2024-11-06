@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-sky-400 focus:ring-sky-400 rounded-md shadow-sm']) !!}>
