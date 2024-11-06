<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Vytvorená rezervácia
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="my-5">
            <div class="m-auto max-w-sm bg-white border border-gray-200 rounded-lg shadow">
                    @if($company->image)
                    <img class="rounded-t-lg" src="{{ URL::asset($company->image) }}" alt="">
                    @endif
                <div class="p-5">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Úspešné
                            vytvorenie rezervácie</h5>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Názov podniku : {{ $company->name }}</p>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Názov služby : {{ $service->name }}</p>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Začiatok rezervácie : {{ $reservation->start_at }}</p>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Koniec rezervácie : {{ $reservation->end_at }}</p>
                    <div class="mt-3">
                        <a class="mb-5 group relative inline-flex items-center overflow-hidden rounded bg-sky-400 px-8 py-3 text-white focus:outline-none focus:ring active:bg-sky-400"
                            href="{{ route('fo.reservations.show-calendar') }}">
                            <span class="absolute -start-full transition-all group-hover:start-4">
                                <svg class="size-5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </span>
                            <span class="text-sm font-medium transition-all group-hover:ms-4"> Moje rezervácie
                            </span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>