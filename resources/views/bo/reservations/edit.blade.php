<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Zrušenie rezervácie podniku {{ $selectedCompany->name }}
        </h2>
    </x-slot>

    <div class="mt-10 flex flex-col items-center">
        <div class="w-full sm:max-w-md">
            <a class="ml-5 sm:ml-0 inline-block rounded-full border border-sky-400 bg-sky-400 p-3 text-white hover:bg-transparent hover:text-sky-400 focus:outline-none focus:ring active:text-sky-400"
                href="{{ route('bo.reservations.all') }}">
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

            <form id="bo-reservations-update" class="mb-10" method="post"
                action="{{ route('bo.reservations.update', $reservation->id) }}">
                @csrf
                @method('put')

                <div>
                    <h4 class="text-lg font-bold">Názov služby</h4>
                    <h4 class="text-lg">{{ $reservation->getServiceName() }}</h4>
                </div>

                <div class="mt-4">
                    <h4 class="text-lg font-bold">Meno zákazníka</h4>
                    <h4 class="text-lg">{{ $reservation->getUserName() }}</h4>
                </div>

                <div class="mt-4">
                    <h4 class="text-lg font-bold">Začiatok</h4>
                    <h4 class="text-lg">{{ $reservation->start_at }}</h4>
                </div>

                <div class="mt-4">
                    <h4 class="text-lg font-bold">Koniec</h4>
                    <h4 class="text-lg">{{ $reservation->end_at }}</h4>
                </div>

                <div class="mt-4">
                    <label for="reason_for_cancellation" class="text-lg font-bold mb-2">Dôvod zrušenia</label>
                    <textarea name="reason_for_cancellation" id="reason_for_cancellation" rows="4" 
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-sky-400 focus:border-sky-400 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('reason_for_cancellation') }}</textarea>
                    <x-input-error :messages="$errors->get('reason_for_cancellation')" class="mt-2" />
                </div>

                <div class="flex mr-5 sm:mr-0 items-center justify-end mt-4">
                    <button type="submit"
                            class="show_confirm focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Potvrdiť zrušenie</button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>