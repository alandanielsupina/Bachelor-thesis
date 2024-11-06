<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Všetky kategórie
        </h2>
    </x-slot>

    <div class="my-10 lg:mx-5">
        <a class="mb-5 group relative inline-flex items-center overflow-hidden rounded bg-sky-400 px-8 py-3 text-white focus:outline-none focus:ring active:bg-sky-400"
            href="{{ route('bo.categories.create') }}">
            <span class="absolute -start-full transition-all group-hover:start-4">
                <svg class="size-5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </span>

            <span class="text-sm font-medium transition-all group-hover:ms-4"> Vytvoriť kategóriu </span>
        </a>
        @if (!$categories->isEmpty())
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
                            vytvorenie
                        </th>
                        <th scope="col" class="px-6 py-3">
                            aktualizácia
                        </th>
                        <th scope="col" class="px-6 py-3">
                            odstránenie
                        </th>
                        <th scope="col" class="px-6 py-3">
                            akcia
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
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
                            {{ $category->id }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $category->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $category->created_at }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $category->updated_at }}
                        </td>
                        @if ($category->deleted_at === NULL)
                        <td class="px-6 py-4">
                            XXX
                        </td>
                        @else
                        <td class="px-6 py-4">
                            {{ $category->deleted_at }}
                        </td>
                        @endif
                        <td class="px-6 py-4 text-base">
                            <button id="dropdownDefaultButton"
                                data-dropdown-toggle="dropdown-actions-categories-{{$category->id}}" type="button"><svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14"/>
                                  </svg>                                  
                            </button>

                            <!-- Dropdown menu -->
                            <div id="dropdown-actions-categories-{{$category->id}}"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownDefaultButton">
                                    <li>
                                        {{-- edit --}}
                                        @if ($category->deleted_at === NULL)
                                        <a id="bo-categories-all-edit"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                            href="{{ route('bo.categories.edit', $category->id) }}">Upraviť</a>
                                        @endif
                                    </li>
                                    <li>
                                        {{-- destroy --}}
                                        @if ($category->deleted_at === NULL)
                                        <form id="bo-categories-all-destroy" method="post"
                                            action="{{ route('bo.categories.destroy', $category->id) }}"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            @csrf
                                            @method('delete')
                                            <input type="submit" value="Odstrániť" class="show_confirm">
                                        </form>
                                    </li>
                                    <li>
                                        {{-- restore --}}
                                        @else
                                        <form id="bo-categories-all-restore" method="post"
                                            action="{{ route('bo.categories.restore', $category->id) }}"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            @csrf
                                            <input type="submit" value="Obnoviť">
                                        </form>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </td>

                        {{-- TODO: toto pôjde určite preč, ale je tu dobrý príklad toho, že sa $user->id nesprávne
                        posielalo ako parameter cez tag "a" --}}
                        {{-- <td class="px-6 py-4">
                            <form id="bo-users-all-destroy" method="post"
                                action="{{ route('bo.users.destroy', $user->id) }}"
                                class="font-medium cursor-pointer text-white hover:underline">
                                @csrf
                                @method('delete')
                                <a onclick="document.getElementById('bo-users-all-destroy').submit()">Odstrániť</a>
                            </form>
                        </td> --}}
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <h1 class="text-3xl mb-4 mt-10 font-bold text-red-600 text-center">Žiadne kategórie</h1>
        @endif
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