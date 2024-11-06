<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Všetky rezervácie podniku {{ $selectedCompany->name }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="my-10">


            <div class="flex flex-row justify-end">
                <div class="w-1/2">
                    <h3 class="text-xl font-bold mb-2">Filtrovanie začiatku rezervácie</h3>
                    <form method="post" action="{{ route('bo.reservations.filter-start-date') }}"
                        class="flex flex-row sm:flex-nowrap flex-wrap justify-end mb-1">
                        @csrf
                        <div class="flex-1">
                            <label for="dateFrom" class="block text-sm font-medium text-gray-700">Od</label>
                            <input type="date" id="dateFrom" name="dateFrom"
                                class="block w-full pl-3 pr-10 py-2 text-sm border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="flex-1 sm:ml-4">
                            <label for="dateTo" class="block text-sm font-medium text-gray-700">Do</label>
                            <input type="date" id="dateTo" name="dateTo"
                                class="block w-full pl-3 pr-10 py-2 text-sm border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="ml-4 content-end">
                            <input type="submit" value="Vyhľadať"
                                class="bg-sky-400 text-white px-4 py-2 rounded-md hover:bg-sky-500 cursor-pointer">
                        </div>
                    </form>
                </div>
            </div>

            <div class="flex flex-row justify-end mt-1 mb-2">
                <a href="{{ route('bo.reservations.all') }}" class="ml-4 bg-sky-400 text-white px-4 py-2 rounded-md hover:bg-sky-500 cursor-pointer">
                    Zobraziť všetky
                </a>
            </div>

            @if (!$reservations->isEmpty())
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-black dark:text-blue-100">
                    <thead class="text-xs text-white uppercase bg-gray-400 dark:text-white">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                id
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Názov služby
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Meno zákazníka
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Vytvorenie
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Začiatok
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Koniec
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Zrušené
                            </th>
                            <th scope="col" class="px-6 py-3">
                                akcia
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservations as $reservation)
                        @if ($loop->index % 2 === 0)

                        @if ($loop->last)
                        <tr class="bg-white">
                            @else
                        <tr class="bg-white border-b border-black">
                            @endif

                            @else

                            @if ($loop->last)
                        <tr class="bg-gray-100">
                            @else
                        <tr class="bg-gray-100 border-b border-black">
                            @endif

                            @endif
                            <th scope="row" class="px-6 py-4 font-mediu whitespace-nowrap dark:text-blue-100">
                                {{ $reservation->id }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $reservation->getServiceName() }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $reservation->getUserName() }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $reservation->created_at }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $reservation->start_at }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $reservation->end_at }}
                            </td>
                            @if ($reservation->cancelled_at === NULL)
                            <td class="px-6 py-4">
                                XXX
                            </td>
                            @else
                            <td class="px-6 py-4">
                                {{ $reservation->cancelled_at }}
                            </td>
                            @endif

                            <td class="px-6 py-4 text-base">
                                @if ($reservation->cancelled_at === NULL)
                                <form method="get" action="{{ route('bo.reservations.edit', $reservation->id) }}"
                                    class="font-medium cursor-pointer hover:underline">
                                    @csrf
                                    <input type="submit" value="Zrušiť" class="cursor-pointer hover:underline">
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <h1 class="text-3xl mb-4 mt-10 font-bold text-red-600 text-center">Žiadne rezervácie</h1>
            @endif
        </div>
    </div>
</x-app-layout>