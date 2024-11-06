<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Upravenie základných informácií podniku {{ $selectedCompany->name }}
        </h2>
    </x-slot>

    <div class="mt-10 flex flex-col items-center">
        <div class="w-full sm:max-w-md">
            <a class="ml-5 sm:ml-0 inline-block rounded-full border border-sky-400 bg-sky-400 p-3 text-white hover:bg-transparent hover:text-sky-400 focus:outline-none focus:ring active:text-sky-400"
                href="{{ route('bo.basic-informations.show') }}">
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

            @if ($selectedCompany)
            <div class="mb-10">
                <form method="post" action="{{ route('bo.basic-informations.update', $selectedCompany->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <!-- Name -->
                    <div>
                        <label for="name" class="text-lg font-bold mb-2">Názov</label>
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            :value="$selectedCompany->name" autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- City -->
                    <div class="mt-4">
                        <label for="city" class="text-lg font-bold mb-2">Mesto</label>
                        <x-text-input id="city" class="block mt-1 w-full" type="text" name="city"
                            :value="$selectedCompany->city" autofocus />
                        <x-input-error :messages="$errors->get('city')" class="mt-2" />
                    </div>

                    <!-- Address -->
                    <div class="mt-4">
                        <label for="address" class="text-lg font-bold mb-2">Adresa</label>
                        <x-text-input id="address" class="block mt-1 w-full" type="text" name="address"
                            :value="$selectedCompany->address" autofocus />
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div class="mt-4">
                        <label for="description" class="text-lg font-bold mb-2">Popis</label>
                        <textarea name="description" id="description" rows="4"
                            class="block p-2.5 w-full bg-gray-50 rounded-lg border border-gray-300 focus:ring-sky-400 focus:border-sky-400 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $selectedCompany->description }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Image -->
                    <div class="mt-4">
                        <label for="image" class="text-lg font-bold mb-2">Fotka podniku</label>
                        <input type="file" name="image" id="image">
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <!-- Categories -->
                    <div class="mt-4">
                        <label for="dropdownSearchButton" class="block text-lg font-bold mb-2">Kategórie</label>
                        <button id="dropdownSearchButton" data-dropdown-toggle="dropdownSearch"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-sky-400 rounded-lg hover:bg-sky-500 focus:ring-4 focus:outline-none focus:ring-sky-300"
                            type="button">Vybrať kategóriu <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg></button>

                        <!-- Dropdown menu -->
                        <div id="dropdownSearch" class="z-10 hidden bg-white rounded-lg shadow w-100 dark:bg-gray-700">
                            <ul class="h-48 px-3 pb-3 overflow-y-auto text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownSearchButton">

                                @forelse ($categories as $category)
                                <li>
                                    <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <input id="category-{{ $category->id }}" type="checkbox" name="categories[]"
                                            value="{{ $category->id }}" {{
                                            $selectedCompany->categories->contains($category)
                                        ? 'checked' : '' }}
                                        class="w-4 h-4 text-sky-400 bg-gray-100 border-gray-300 rounded
                                        focus:ring-sky-400
                                        dark:focus:ring-sky-500 dark:ring-offset-gray-700
                                        dark:focus:ring-offset-gray-700
                                        focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="category-{{ $category->id }}"
                                            class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">{{
                                            $category->name }}</label>
                                    </div>
                                </li>
                                @empty
                                <li>
                                    <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <h3>Žiadne kategórie</h3>
                                    </div>
                                </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="mt-4 right-* text-white bg-sky-400 hover:bg-sky-500 focus:ring-4 focus:ring-sky-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Uložiť</button>
                    </div>
                </form>
            </div>
            @else
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                role="alert">
                Nastala chyba. Nie je vybraný podnik!
            </div>
            @endif
        </div>
    </div>

    @push('scripts')
    {{-- kvôli dropdown pre kategórie --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    @endpush
</x-app-layout>