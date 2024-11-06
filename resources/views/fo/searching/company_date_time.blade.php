<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Čas rezervácie {{ $company->name }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="my-5">

            <a class="ml-5 sm:ml-0 inline-block rounded-full border border-sky-400 bg-sky-400 p-3 text-white hover:bg-transparent hover:text-sky-400 focus:outline-none focus:ring active:text-sky-400"
                href="{{ route('fo.searching.show-company-services', [$selectedCity, $company->id]) }}">
                <span class="sr-only"> Naspäť </span>

                <svg class="size-5 rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>


            <div class="mt-7 flex flex-column justify-center">
                <div class="w-1/2 sm:w-1/3 lg:w-1/5">

                    @if ( session()->has('error'))
                    <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                        role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                        <span class="sr-only">Info</span>
                        <div>
                            {{ session()->get('error') }}
                        </div>
                    </div>
                    @endif

                    <h4 class="text-lg font-bold mb-5">{{ $service->name }}</h4>
                    <form method="post"
                        action="{{ route('fo.searching.store', [$selectedCity, $company->id, $service->id]) }}"
                        class="flex flex-col flex-wrap justify-end mb-1">
                        @csrf
                        <div class="flex-1 w-full">
                            <label for="date" class="text-md font-bold mb-2">Dátum</label>
                            <input type="date" id="date" name="date" value="{{ old('date') }}"
                                class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5" />
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>

                        <div class="flex-1 mt-3 w-full">
                            <label for="time" class="text-md font-bold mb-2">Čas</label>
                            <input type="time" id="time" name="time" value="{{ old('time') }}"
                                class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5" />
                            <x-input-error :messages="$errors->get('time')" class="mt-2" />
                        </div>
                        <div class="flex-1 mt-9 w-full">
                            <input type="submit" value="Rezervovať"
                                class="block w-full bg-sky-400 text-white px-4 py-2 rounded-md hover:bg-sky-500 cursor-pointer">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    @endpush
</x-app-layout>