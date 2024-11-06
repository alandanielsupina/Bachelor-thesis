<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Rezervovať
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="my-5">

            <a class="ml-5 sm:ml-0 inline-block rounded-full border border-sky-400 bg-sky-400 p-3 text-white hover:bg-transparent hover:text-sky-400 focus:outline-none focus:ring active:text-sky-400"
                href="{{ route('fo.searching.select-city') }}">
                <span class="sr-only"> Naspäť </span>

                <svg class="size-5 rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>


            <div class="mt-4 md:w-1/2 m-auto">
                <div class="flex flex-wrap justify-center gap-4">
                    @foreach ($categories as $category)
                    <form method="post" action="{{ route('fo.searching.filter-category', $selectedCity) }}">
                        @csrf
                        <input type="hidden" name="category" value="{{ $category->name }}">
                        <button type="submit"
                            class="bg-sky-400 hover:bg-sky-500 focus:ring-4 focus:outline-none focus:ring-sky-300 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex items-center text-white">
                            {{ $category->name }}
                        </button>
                    </form>
                    @endforeach
                    <form method="post" action="{{ route('fo.searching.filter-category', $selectedCity) }}">
                        @csrf
                        <input type="hidden" name="category" value="all">
                        <button type="submit"
                            class="bg-purple-400 hover:bg-purple-500 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex items-center text-white">
                            Všetko
                        </button>
                    </form>
                </div>
            </div>


            <form method="get" action="{{ route('fo.searching.search-company-name', $selectedCity) }}" class="max-w-md mx-auto mt-3">
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="search" id="default-search" name="search"
                        class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Názov podniku"/>
                    <button type="submit"
                        class="text-white absolute end-2.5 bottom-2.5 bg-sky-400 hover:bg-sky-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Hľadať</button>
                </div>
            </form>


            @if (!$companies->isEmpty())
            <div class="mt-4 grid lg:grid-cols-2 xl:grid-cols-3 lg:justify-center">
                @foreach ($companies as $company)
                <div class="flex justify-center">
                    <form id="fo-searching-show-company-{{ $company->id }}" method="get"
                        action="{{ route('fo.searching.show-company', [$selectedCity, $company->id]) }}"
                        class="font-medium cursor-pointer text-white max-w-sm w-full">
                        @csrf
                        <a onclick="document.getElementById('fo-searching-show-company-{{ $company->id }}').submit()"
                            class="no-underline mb-5 block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{
                                $company->name }}</h5>
                            <h6 class="inline mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white">{{
                                $company->city }},</h6>
                            <h6 class="inline mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white">{{
                                $company->address }}</h6>
                            <div class="flex flex-wrap justify-start gap-4">
                                @foreach ($company->categories as $category)
                                <div class="bg-gray-400 p-2 rounded-lg">{{ $category->name }}</div>
                                @endforeach
                            </div>
                        </a>
                    </form>
                </div>
                @endforeach
            </div>
            @else
            <h1 class="text-3xl mb-4 mt-10 font-bold text-red-600 text-center">Zatiaľ žiadne podniky</h1>
            @endif
        </div>
    </div>
</x-app-layout>