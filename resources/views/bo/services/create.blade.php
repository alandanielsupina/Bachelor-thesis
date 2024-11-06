<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Vytvorenie novej služby podniku {{ $selectedCompany->name }}
        </h2>
    </x-slot>

    <div class="mt-10 flex flex-col items-center">
        <div class="w-full sm:max-w-md">
            <a class="ml-5 sm:ml-0 inline-block rounded-full border border-sky-400 bg-sky-400 p-3 text-white hover:bg-transparent hover:text-sky-400 focus:outline-none focus:ring active:text-sky-400"
                href="{{ route('bo.services.all') }}">
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

            <form id="bo-services-create" class="mb-10" method="post" action="{{ route('bo.services.store') }}">
                @csrf
                <div>
                    <label for="name" class="text-lg font-bold mb-2">Názov</label>
                    <x-text-input id="name" class="block w-full" type="text" name="name" :value="old('name')"
                        autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <label for="price" class="text-lg font-bold mb-2">Cena</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="text-gray-500 sm:text-sm">€</span>
                        </div>
                        <input id="price" type="number" step="0.01" min="0" placeholder="0.00" name="price"
                            class="block w-full rounded-md border border-gray-300 text-gray-900 text-sm focus:border-sky-400 focus:ring-sky-400 p-2.5 pl-7">
                    </div>
                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <label for="length" class="text-lg font-bold mb-2">Dĺžka v minútach</label>
                    <input id="length" type="number" min="0" placeholder="0"
                        oninput="this.value = 
                                                   !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" aria-describedby="helper-text-explanation"
                        name="length"
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-sky-400 focus:ring-sky-400 block w-full p-2.5" />
                    <x-input-error :messages="$errors->get('length')" class="mt-2" />
                </div>

                <div class="flex mr-5 sm:mr-0 items-center justify-end mt-4">
                    <button type="submit"
                        class="text-white bg-sky-400 hover:bg-sky-500 focus:ring-4 focus:ring-sky-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Potvrdiť</button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>