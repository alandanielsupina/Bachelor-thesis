<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Všetky služby podniku {{ $selectedCompany->name }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="my-10">

            <a class="mb-5 group relative inline-flex items-center overflow-hidden rounded bg-sky-400 px-8 py-3 text-white focus:outline-none focus:ring active:bg-sky-400"
                href="{{ route('bo.services.create') }}">
                <span class="absolute -start-full transition-all group-hover:start-4">
                    <svg class="size-5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </span>

                <span class="text-sm font-medium transition-all group-hover:ms-4"> Vytvoriť službu </span>
            </a>
            @if (!$services->isEmpty())
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-black dark:text-blue-100">
                    <thead class="text-xs text-white uppercase bg-gray-400 dark:text-white">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                id
                            </th>
                            <th scope="col" class="px-6 py-3">
                                názov
                            </th>
                            <th scope="col" class="px-6 py-3">
                                cena
                            </th>
                            <th scope="col" class="px-6 py-3">
                                dĺžka v minútach
                            </th>
                            <th scope="col" class="px-6 py-3">
                                vytvorenie
                            </th>
                            <th scope="col" class="px-6 py-3">
                                aktualizácia
                            </th>
                            <th scope="col" class="px-6 py-3">
                                akcia
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $service)
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
                                {{ $service->id }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $service->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $service->price }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $service->length }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $service->created_at }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $service->updated_at }}
                            </td>

                            <td class="px-6 py-4 text-base">
                                <button id="dropdownDefaultButton"
                                    data-dropdown-toggle="dropdown-actions-services-{{$service->id}}" type="button"><svg
                                        class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                            d="M5 7h14M5 12h14M5 17h14" />
                                    </svg>
                                </button>

                                <!-- Dropdown menu -->
                                <div id="dropdown-actions-services-{{$service->id}}"
                                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                        aria-labelledby="dropdownDefaultButton">
                                        <li>
                                            {{-- edit --}}
                                            <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                                href="{{ route('bo.services.edit', $service->id) }}">Upraviť</a>
                                        </li>
                                        <li>
                                            {{-- destroy --}}
                                            <form method="post"
                                                action="{{ route('bo.services.destroy', $service->id) }}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                @csrf
                                                @method('delete')
                                                <input type="submit" value="Odstrániť" class="show_confirm">
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <h1 class="text-3xl mb-4 mt-10 font-bold text-red-600 text-center">Žiadne služby</h1>
            @endif
        </div>
    </div>

    @push('scripts')
    {{-- kvôli dropdown pre akcie --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    {{-- kvôli alertu --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $('.show_confirm').click(function(event) {
          var form =  $(this).closest("form");
          event.preventDefault();

          swal.fire({
              title: `Naozaj chcete odstrániť tento záznam?`,
              showDenyButton: true,
              showConfirmButton: false,
              showCancelButton: true,
              denyButtonText: 'Vymazať',
              cancelButtonText: 'Zrušiť',
              icon: "warning",
              dangerMode: true,
          })
          .then((result) => {
            if (result.isDenied) {
              form.submit();
            }
          });
        });
  
    </script>
    @endpush
</x-app-layout>