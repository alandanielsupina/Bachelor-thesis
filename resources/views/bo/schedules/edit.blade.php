<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 leading-tight">
            Upravenie otváracích hodín podniku {{ $selectedCompany->name }}
        </h2>
    </x-slot>

    <div class="mt-10 flex flex-col items-center">
        <div class="w-full sm:max-w-md">
            <a class="ml-5 sm:ml-0 inline-block rounded-full border border-sky-400 bg-sky-400 p-3 text-white hover:bg-transparent hover:text-sky-400 focus:outline-none focus:ring active:text-sky-400"
                href="{{ route('bo.schedules.show') }}">
                <span class="sr-only"> Naspäť </span>

                <svg class="size-5 rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>

            @if ( session()->has('success'))
            <div class="mb-5 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 " role="alert">
                <p class="font-bold">{{ session()->get('success') }}</p>
            </div>
            @endif

            <form id="bo-schedules-edit" class="mb-10" method="post" action="{{ route('bo.schedules.update') }}">

                @csrf
                @method('put')
                {{-- Select days --}}
                <div class="mt-4">
                    <button id="dropdownSearchButton" data-dropdown-toggle="dropdownSearch"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-sky-400 rounded-lg hover:bg-sky-500 focus:ring-4 focus:outline-none focus:ring-sky-300"
                        type="button">Vybrať dni <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg></button>

                    <!-- Dropdown menu -->

                    <div id="dropdownSearch" class="z-10 hidden bg-white rounded-lg shadow w-100 dark:bg-gray-700">
                        <ul class="h-auto px-3 pb-3 overflow-y-auto text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="dropdownSearchButton">
                            @php
                            $days = ['mon' => 'Pondelok', 'tue' => 'Utorok', 'wed' => 'Streda', 'thu' => 'Štvrtok',
                            'fri' => 'Piatok', 'sat' => 'Sobota', 'sun' => 'Nedeľa'];
                            @endphp

                            @foreach($days as $shortName => $fullName)
                            <li>
                                <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <input id="{{ $shortName }}" type="checkbox" name="days[]" value="{{ $shortName }}"
                                        class="day-checkbox w-4 h-4 text-sky-400 bg-gray-100 border-gray-300 rounded focus:ring-sky-400 dark:focus:ring-sky-500 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                                        {{ in_array($shortName, $schedules->pluck('day')->toArray()) ? 'checked' : ''
                                    }}>
                                    <label for="{{ $shortName }}"
                                        class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">{{
                                        $fullName }}</label>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                @if ( session()->has('error'))
                <x-input-error :messages="session()->get('error')" class="mt-2" />
                @endif

                @php
                $days = ['Pondelok' => 'mon', 'Utorok' => 'tue', 'Streda' => 'wed', 'Štvrtok' => 'thu', 'Piatok' =>
                'fri', 'Sobota' => 'sat', 'Nedeľa' => 'sun'];
                @endphp

                @foreach($days as $fullName => $shortName)
                <div id="block-{{ $shortName }}" class="hidden mt-4">
                    <h4 class="text-xl font-bold mb-2">{{ $fullName }}</h4>

                    <div class="flex justify-around mb-5">
                        <div class="w-5/12">
                            <label for="{{ $shortName }}-start" class="text-lg font-bold mb-2">Začiatok dňa</label>
                            <input type="time" id="{{ $shortName }}-start" name="{{ $shortName }}-start"
                                class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="{{ $schedules->where('day', $shortName)->first() ? $schedules->where('day', $shortName)->first()->getStartHoursMinutes() : '08:30' }}" />
                            <x-input-error :messages="$errors->get('{{ $shortName }}-start')" class="mt-2" />
                        </div>

                        <div class="w-5/12">
                            <label for="{{ $shortName }}-end" class="text-lg font-bold mb-2">Koniec dňa</label>
                            <input type="time" id="{{ $shortName }}-end" name="{{ $shortName }}-end"
                                class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="{{ $schedules->where('day', $shortName)->first() ? $schedules->where('day', $shortName)->first()->getEndHoursMinutes() : '20:00' }}" />
                            <x-input-error :messages="$errors->get('{{ $shortName }}-end')" class="mt-2" />
                        </div>
                    </div>
                </div>
                @endforeach

                {{-- @php
                $days = ['Pondelok' => 'mon', 'Utorok' => 'tue', 'Streda' => 'wed', 'Štvrtok' => 'thu', 'Piatok' =>
                'fri', 'Sobota' => 'sat', 'Nedeľa' => 'sun'];
                @endphp

                @foreach($days as $fullName => $shortName)
                <div id="block-{{ $shortName }}" class="hidden mt-4">
                    <h4 class="text-xl font-bold mb-2">{{ $fullName }}</h4>

                    <div class="flex justify-around mb-5">
                        <div class="w-5/12">
                            <label for="{{ $shortName }}-start" class="text-lg font-bold mb-2">Začiatok dňa</label>
                            <input type="time" id="{{ $shortName }}-start" name="{{ $shortName }}-start"
                                class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="08:30" />
                            <x-input-error :messages="$errors->get('{{ $shortName }}-start')" class="mt-2" />
                        </div>

                        <div class="w-5/12">
                            <label for="{{ $shortName }}-end" class="text-lg font-bold mb-2">Koniec dňa</label>
                            <input type="time" id="{{ $shortName }}-end" name="{{ $shortName }}-end"
                                class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="20:00" />
                            <x-input-error :messages="$errors->get('{{ $shortName }}-end')" class="mt-2" />
                        </div>
                    </div>
                </div>
                @endforeach --}}

                <div class="flex mr-5 sm:mr-0 items-center justify-end mt-4">
                    <button type="submit"
                        class="text-white bg-sky-400 hover:bg-sky-500 focus:ring-4 focus:ring-sky-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Uložiť
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    {{-- kvôli dropdown pre dni --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            // Po načítaní stránky skontroluj stav checkboxov
            $(".day-checkbox").each(function() {
                var checkboxId = $(this).attr("id");
                var blockId = "block-" + checkboxId;
                // Ak je checkbox označený, zobraz príslušný blok
                if ($(this).is(":checked")) {
                    $("#" + blockId).css("display", "block");
                } else {
                    $("#" + blockId).css("display", "none");
                }
            });

            // Po kliknutí na checkbox pre deň
            $(".day-checkbox").change(function(){
                var checkboxId = $(this).attr("id");
                var blockId = "block-" + checkboxId;
                $("#" + blockId).css("display", $(this).is(":checked") ? "block" : "none");
            });
        });
    </script>
    @endpush
</x-app-layout>