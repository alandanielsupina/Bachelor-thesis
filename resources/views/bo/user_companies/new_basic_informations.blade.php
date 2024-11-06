<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Vytvorenie základných informácií
        </h2>
    </x-slot>

    <div class="mt-10 flex flex-col items-center">
        <div class="w-full sm:max-w-md">
            <a class="ml-5 sm:ml-0 inline-block rounded-full border border-sky-400 bg-sky-400 p-3 text-white hover:bg-transparent hover:text-sky-400 focus:outline-none focus:ring active:text-sky-400"
                href="{{ route('bo.user-companies.all') }}">
                <span class="sr-only"> Naspäť </span>

                <svg class="size-5 rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>

            <form id="bo-user-companies-create-basic-informations" class="mb-10" method="post"
                action="{{ route('bo.user-companies.store-basic-informations') }}" enctype="multipart/form-data">
                @csrf
                <!-- Name -->
                <div>
                    <label for="name" class="text-lg font-bold mb-2">Názov</label>
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                        autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- City -->
                <div class="mt-4">
                    <label for="city" class="text-lg font-bold mb-2">Mesto</label>
                    <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')"
                        autofocus />
                    <x-input-error :messages="$errors->get('city')" class="mt-2" />
                </div>

                <!-- Address -->
                <div class="mt-4">
                    <label for="address" class="text-lg font-bold mb-2">Adresa</label>
                    <x-text-input id="address" class="block mt-1 w-full" type="text" name="address"
                        :value="old('address')" autofocus />
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>

                <!-- Description -->
                <div class="mt-4">
                    <label for="description" class="text-lg font-bold mb-2">Popis</label>
                    <textarea name="description" id="description" rows="4" 
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-sky-400 focus:border-sky-400 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('description') }}</textarea>
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
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg></button>

                    <!-- Dropdown menu -->
                    <div id="dropdownSearch" class="z-10 hidden bg-white rounded-lg shadow w-100 dark:bg-gray-700">
                        {{-- <div class="p-3">
                            <label for="input-group-search" class="sr-only">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                <input type="text" id="input-group-search"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Search user">
                            </div>
                        </div> --}}
                        <ul class="h-48 px-3 pb-3 overflow-y-auto text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="dropdownSearchButton">

                            @forelse ($categories as $category)
                            <li>
                                <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <input id="category-{{ $category->id }}" type="checkbox" name="categories[]" value="{{ $category->id }}"
                                        class="w-4 h-4 text-sky-400 bg-gray-100 border-gray-300 rounded focus:ring-sky-400 dark:focus:ring-sky-500 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
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

                <div class="flex mr-5 sm:mr-0 items-center justify-end mt-4">
                    <button type="submit"
                        class="text-white bg-sky-400 hover:bg-sky-500 focus:ring-4 focus:ring-sky-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Ďalej</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    {{-- kvôli dropdown pre kategórie --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    @endpush
</x-app-layout>