<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Všetky podniky
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="my-10">
            @if ( session()->has('error'))
            <div id="alert-2"
                class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                role="alert">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <div class="ms-3 text-sm font-medium">
                    {{ session()->get('error') }}
                </div>
                <button type="button"
                    class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"
                    data-dismiss-target="#alert-2" aria-label="Close">
                    <span class="sr-only">Zatvoriť</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
            @endif

            <a class="mb-5 group relative inline-flex items-center overflow-hidden rounded bg-sky-400 px-8 py-3 text-white focus:outline-none focus:ring active:bg-sky-400"
                href="{{ route('bo.user-companies.preparation-for-new-company') }}">
                <span class="absolute -start-full transition-all group-hover:start-4">
                    <svg class="size-5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </span>
                <span class="text-sm font-medium transition-all group-hover:ms-4">Vytvoriť podnik</span>
            </a>

            @if ($selectedCompany)
            <h1 class="text-3xl font-bold pb-1.5  border-b border-black">Zvolený podnik : {{ $selectedCompany->name }}
            </h1>
            @else
            <h1 class="text-3xl font-bold pb-1.5  border-b border-black">Žiadny zvolený podnik</h1>
            @endif

            <h1 class="text-3xl font-bold mt-1.5 mb-3">Všetky podniky</h1>
            @forelse ($allMyCompanies as $item)
            <form id="bo-user-companies-all-select-company-{{$item->id}}" method="post"
                action="{{ route('bo.user-companies.select-company', $item->id) }}"
                class="font-medium cursor-pointer text-white hover:underline">
                @csrf
                <a onclick="document.getElementById('bo-user-companies-all-select-company-{{$item->id}}').submit()"
                    class="mb-5 block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $item->name }}
                    </h5>
                    <h6 class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white">{{ $item->city }}
                    </h6>
                    <h6 class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white">{{ $item->address }}
                    </h6>
                </a>
            </form>
            @empty
            <h1 class="text-3xl mb-4 mt-10 font-bold text-red-600 text-center">Ešte nemáte vytvorené podniky</h1>
            @endforelse
        </div>
    </div>

    @push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    {{-- kvôli error --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    @endpush
</x-app-layout>