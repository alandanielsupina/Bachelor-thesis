<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Otváracie hodiny podniku {{ $selectedCompany->name }}
        </h2>
    </x-slot>

    <div class="mt-10 flex flex-col items-center">
        <div class="w-full sm:max-w-md">
            @if ($selectedCompany)
            <div class="mb-10">
                @php
                $days = ['Pondelok' => 'mon', 'Utorok' => 'tue', 'Streda' => 'wed', 'Štvrtok' => 'thu', 'Piatok' =>
                'fri', 'Sobota' => 'sat', 'Nedeľa' => 'sun'];
                @endphp

                @if (!$schedules->isEmpty())
                @foreach(['Pondelok', 'Utorok', 'Streda', 'Štvrtok', 'Piatok', 'Sobota', 'Nedeľa'] as $day)
                @if ($schedule = $schedules->firstWhere('day', $days[$day]))
                <div class="mt-4">
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
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                    role="alert">
                    Nastala chyba. Vybraný podnik nemá žiadne otváracie hodiny!
                </div>
                @endif



                @else
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                    role="alert">
                    Nastala chyba. Nie je vybraný podnik!
                </div>
                @endif

                <div class="flex justify-end mt-4">
                    <form method="get" action="{{ route('bo.schedules.edit', $selectedCompany->id) }}">
                        @csrf
                        <button type="submit"
                            class="text-white bg-sky-400 hover:bg-sky-500 focus:ring-4 focus:ring-sky-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Upraviť</button>
                    </form>
                </div>
            </div>
        </div>
</x-app-layout>