<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Základne informácie podniku {{ $selectedCompany->name }}
        </h2>
    </x-slot>

    <div class="mt-10 flex flex-col items-center">
        <div class="w-full sm:max-w-md">
            @if ($selectedCompany)
            <div class="mb-10">
                <form>
                    <!-- Name -->
                    <div>
                        <label for="name" class="text-lg font-bold mb-2">Názov</label>
                        <x-text-input id="name" class="block mt-1 w-full bg-gray-200" type="text" name="name"
                            :value="$selectedCompany->name" disabled autofocus />
                    </div>

                    <!-- City -->
                    <div class="mt-4">
                        <label for="city" class="text-lg font-bold mb-2">Mesto</label>
                        <x-text-input id="city" class="block mt-1 w-full bg-gray-200" type="text" name="city"
                            :value="$selectedCompany->city" disabled autofocus />
                    </div>

                    <!-- Address -->
                    <div class="mt-4">
                        <label for="address" class="text-lg font-bold mb-2">Adresa</label>
                        <x-text-input id="address" class="block mt-1 w-full bg-gray-200" type="text" name="address"
                            disabled :value="$selectedCompany->address" autofocus />
                    </div>

                    <!-- Description -->
                    <div class="mt-4">
                        <label for="description" class="text-lg font-bold mb-2">Popis</label>
                        <textarea name="description" id="description" rows="4"
                            class="block p-2.5 w-full bg-gray-200 rounded-lg border border-gray-300 focus:ring-sky-400 focus:border-sky-400 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            disabled>{{ $selectedCompany->description }}</textarea>
                    </div>

                    <!-- Image -->
                    @if($selectedCompany->image)
                    <img src="{{ URL::asset($selectedCompany->image) }}" class="mt-4" alt="">
                    @endif

                    <!-- Categories -->
                    <div class="mt-4">
                        <label for="address" class="text-lg font-bold mb-2">Kategórie</label>
                        @if (!$selectedCompany->categories->isEmpty())
                        <div class="flex flex-wrap justify-start gap-4">
                            @foreach ($selectedCompany->categories as $category)
                            <div class="bg-gray-200 p-2 rounded-lg">{{ $category->name }}</div>
                            @endforeach
                        </div>
                        @else
                        <div class="p-4 mb-4 text-md text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                            role="alert">
                            Podnik nemá pridelené žiadne kategórie! Vyberte si aspoň jednu pre lepšie zobrazovanie
                            zákazníkom.
                        </div>
                        @endif
                    </div>


                    {{-- <!-- Categories -->
                    <div class="mt-4">
                        <button id="dropdownSearchButton" data-dropdown-toggle="dropdownSearch"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-sky-400 rounded-lg hover:bg-sky-500 focus:ring-4 focus:outline-none focus:ring-sky-300"
                            type="button">Kategórie <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true"
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
                                        ? 'checked' : '' }} disabled
                                        class="w-4 h-4 text-sky-400 bg-gray-100 border-gray-300 rounded
                                        focus:ring-sky-400
                                        dark:focus:ring-sky-500 dark:ring-offset-gray-700
                                        dark:focus:ring-offset-gray-700
                                        focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="category-{{ $category->id }}"
                                            class="w-full ms-2 text-sm font-medium text-gray-400 rounded dark:text-gray-300">{{
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
                    </div> --}}
                </form>

                <div class="flex justify-end mt-4">
                    <form id="bo-basic-informations-show-destroy" method="post"
                        action="{{ route('bo.basic-informations.destroy', $selectedCompany->id) }}">
                        @csrf
                        @method('delete')
                        <button type="submit"
                            class="show_confirm focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Odstrániť</button>
                    </form>


                    <form method="get" action="{{ route('bo.basic-informations.edit', $selectedCompany->id) }}">
                        @csrf
                        <button type="submit"
                            class="text-white bg-sky-400 hover:bg-sky-500 focus:ring-4 focus:ring-sky-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Upraviť</button>
                    </form>
                </div>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $('.show_confirm').click(function(event) {
        //   var form =  $(this).closest("form");
          var form = $('#bo-basic-informations-show-destroy');
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