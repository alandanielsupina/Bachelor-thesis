<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Rezervovať
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="my-20 flex">

            @if (!empty($uniqueCities))

            <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown"
                class="text-white bg-sky-400 hover:bg-sky-500 focus:ring-4 focus:outline-none focus:ring-sky-300 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/6 mx-auto justify-center"
                type="button" style="transform: scale(1.3)">Vybrať mesto
                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                </svg>
            </button>

            <!-- Dropdown menu with scrollbar -->
            <div id="dropdown"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 overflow-y-auto max-h-56">
                <ul class="py-2 text-md text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                    @foreach ($uniqueCities as $one)
                    {{-- <li>
                        <form action="" method="post" class="w-full">
                            @csrf
                            <input type="hidden" value="{{ $one }}">
                            <button type="submit"
                                class="block w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-left">{{
                                $one }}</button>
                        </form>
                    </li> --}}

                    <li>
                        <a href="{{ route('fo.searching.all', $one) }}"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ $one }}</a>
                    </li>
                    @endforeach

                </ul>
            </div>
            @else
            <h1 class="text-3xl mb-4 mt-10 font-bold text-red-600 text-center">Zatiaľ žiadne podniky</h1>
            @endif
        </div>
    </div>

    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    @endpush
</x-app-layout>