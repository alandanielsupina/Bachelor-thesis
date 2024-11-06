<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Moje rezervácie {{ $day }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="my-5">

            <a class="ml-5 sm:ml-0 inline-block rounded-full border border-sky-400 bg-sky-400 p-3 text-white hover:bg-transparent hover:text-sky-400 focus:outline-none focus:ring active:text-sky-400"
                href="{{ route('fo.reservations.show-calendar') }}">
                <span class="sr-only"> Naspäť </span>

                <svg class="size-5 rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>

            @if (!$reservations->isEmpty())

            @foreach ($reservations as $reservation)
            <div class="flex justify-center">
                <div class="font-medium cursor-pointer text-white max-w-sm w-full">
                    <a href="{{ route('fo.reservations.edit', [ $day, $reservation->id]) }}"
                        class="no-underline mb-5 block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{
                            $reservation->service->name }}</h5>
                        <h6 class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white">{{
                            $reservation->start_at }}</h6>
                        <h6 class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white">{{
                            $reservation->service->price }} €</h6>
                    </a>
                </div>
            </div>
            @endforeach
            @else
            <h1 class="text-3xl mb-4 mt-10 font-bold text-red-600 text-center">Žiadne rezervácie</h1>
            @endif
        </div>
    </div>
</x-app-layout>