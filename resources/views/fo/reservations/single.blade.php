<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Moja rezervácia {{ $reservation->service->name }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="my-5">
            <a class="ml-5 sm:ml-0 inline-block rounded-full border border-sky-400 bg-sky-400 p-3 text-white hover:bg-transparent hover:text-sky-400 focus:outline-none focus:ring active:text-sky-400"
                href="{{ route('fo.reservations.show-day', $day) }}">
                <span class="sr-only"> Naspäť </span>

                <svg class="size-5 rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>

            <div class="flex flex-col items-center">
                <div class="w-full sm:max-w-md">
                    <form id="fo-reservations-update" class="mb-10" method="post"
                        action="{{ route('fo.reservations.update', [ $day, $reservation->id ]) }}">
                        @csrf
                        @method('put')

                        <div class="mt-4">
                            <h4 class="text-lg font-bold">Názov podniku</h4>
                            <h4 class="text-lg">{{ $reservation->service->company->name }}</h4>
                        </div>

                        <div class="mt-4">
                            <h4 class="text-lg font-bold">Názov služby</h4>
                            <h4 class="text-lg">{{ $reservation->getServiceName() }}</h4>
                        </div>

                        <div class="mt-4">
                            <h4 class="text-lg font-bold">Cena</h4>
                            <h4 class="text-lg">{{ $reservation->service->price }} €</h4>
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
                                class="show_confirm focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Potvrdiť
                                zrušenie</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $('.show_confirm').click(function(event) {
        //   var form =  $(this).closest("form");
          var form = $('#fo-reservations-update');
          event.preventDefault();

          swal.fire({
              title: `Naozaj chcete zrušiť túto rezerváciu?`,
              showDenyButton: true,
              showConfirmButton: false,
              showCancelButton: true,
              denyButtonText: 'Áno',
              cancelButtonText: 'Nie',
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