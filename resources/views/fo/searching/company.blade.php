<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $company->name }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="my-5">

            <a class="ml-5 sm:ml-0 inline-block rounded-full border border-sky-400 bg-sky-400 p-3 text-white hover:bg-transparent hover:text-sky-400 focus:outline-none focus:ring active:text-sky-400"
                href="{{ route('fo.searching.all', $selectedCity) }}">
                <span class="sr-only"> Naspäť </span>

                <svg class="size-5 rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>

            <div class="mt-4 min-h-96 flex flex-col lg:flex-row">
                <div class="flex-1 flex flex-col">
                    <div class="ml-3 mt-3">
                        <a class="mb-5 group relative inline-flex items-center overflow-hidden rounded bg-sky-400 px-8 py-3 text-white focus:outline-none focus:ring active:bg-sky-400"
                            href="{{ route('fo.searching.show-company-services', [$selectedCity, $company->id]) }}">
                            <span class="absolute -start-full transition-all group-hover:start-4">
                                <svg class="size-5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </span>

                            <span class="text-sm font-medium transition-all group-hover:ms-4"> Pozrieť služby podniku
                            </span>
                        </a>
                    </div>

                    <div class="flex flex-wrap justify-start gap-4 p-3">
                        @foreach ($company->categories as $category)
                        <div class="bg-sky-300 p-2 rounded-lg">{{ $category->name }}</div>
                        @endforeach
                    </div>

                    <div class="p-3">
                        <h5 class="text-xl font-bold dark:text-white inline">{{ $company->city }},</h5>
                        <h5 class="text-xl font-bold dark:text-white inline">{{ $company->address }}</h5>
                    </div>

                    <div class="p-3">
                        <h4 class="text-2xl font-bold dark:text-white mb-2">Otváracie hodiny</h4>
                        @php
                        $days = ['Pondelok' => 'mon', 'Utorok' => 'tue', 'Streda' => 'wed', 'Štvrtok' => 'thu', 'Piatok'
                        =>
                        'fri', 'Sobota' => 'sat', 'Nedeľa' => 'sun'];
                        @endphp

                        @if (!$company->schedules->isEmpty())
                        @foreach(['Pondelok', 'Utorok', 'Streda', 'Štvrtok', 'Piatok', 'Sobota', 'Nedeľa'] as $day)
                        @if ($schedule = $company->schedules->firstWhere('day', $days[$day]))
                        <div>
                            <h3 class="text-xl font-bold mb-2">{{ $day }}</h3>

                            <div class="flex justify-around mb-5">
                                <div class="w-5/12">
                                    <h6 class="text-lg font-bold mb-2">Začiatok dňa</h6>
                                    <input type="time" disabled
                                        class="bg-gray-200 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        value="{{ $schedule->getStartHoursMinutes() }}" />
                                </div>

                                <div class="w-5/12">
                                    <h6 class="text-lg font-bold mb-2">Koniec dňa</h6>
                                    <input type="time" disabled
                                        class="bg-gray-200 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        value="{{ $schedule->getEndHoursMinutes() }}" />
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                        @else
                        NIE JE kalendar
                        @endif
                    </div>
                </div>

                <div class="flex-1 flex flex-col">
                    <div class="flex-1">
                        @if($company->image)
                        <img src="{{ URL::asset($company->image) }}" alt="">
                        @endif
                    </div>
                    <div class="flex-1 p-3">
                        <p>{{ $company->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>