<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Moje rezervácie
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="my-5">

            <div class="flex justify-center">
                <div id="color-calendar"></div>
            </div>

            <h1 class="text-3xl mb-4 mt-10 font-bold text-center">Dnešné rezervácie</h1>
            @if (!$todayReservations->isEmpty())
            @foreach ($todayReservations as $reservation)
            <div class="flex justify-center">
                <div class="font-medium cursor-pointer text-white max-w-sm w-full">
                    <a href="{{ route('fo.reservations.edit', [ $day, $reservation->id]) }}"
                        class="no-underline mb-5 block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{
                            $reservation->service->name }}</h5>
                        <h6 class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white">{{
                            $reservation->start_at }}</h6>
                        <h6 class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white">{{
                            $reservation->service->price }} €</h6>
                    </a>
                </div>
            </div>
            @endforeach
            @else
            <h2 class="text-2xl mb-4 mt-3 font-bold text-red-600 text-center">Žiadne</h2>
            @endif

        </div>
    </div>

    @push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    {{-- kalendar --}}
    <script>
        let calendar = new Calendar({
                    id: "#color-calendar",
                    calendarSize: "large",
                    selectedDateClicked: (currentDate, filteredDateEvents) => {
                        if (filteredDateEvents[0] !== undefined) {
                            console.log(filteredDateEvents[0].start);
                            window.location.pathname = "moje-rezervacie/den/" + filteredDateEvents[0].start;
                        }
                    }
        });
        calendar.setDate(new Date(2024, 5, 1));

    //     document.addEventListener("DOMContentLoaded", function() {
    //         let calendar;

    //         function setCalendarSize() {
    //             let calendarSize = window.innerWidth <= 768 ? "small" : "large";
    //             calendar = new Calendar({
    //                 id: "#color-calendar",
    //                 calendarSize: calendarSize,
    //                 selectedDateClicked: (currentDate, filteredDateEvents) => {
    //                     if (filteredDateEvents[0] !== undefined) {
    //                         console.log(filteredDateEvents[0].start);
    //                     }
    //                 }
    //             });
    //         }

    //         // Spustit funkci pro nastavení velikosti kalendáře ihned po načtení stránky
    //         setCalendarSize();

    //         // Přidat posluchač události pro změnu velikosti okna
    //         window.addEventListener("resize", setCalendarSize);

    //         // Pridáme udalosti počas inicializácie
    //         calendar.addEventsData([{
    //             start: '2024-04-17T06:00:00',
    //             end: '2024-04-17T20:30:00',
    //             name: 'Dotatočné informácie',
    //         }]);
    // });

    calendar.addEventsData([
        @foreach ($reservationsArray as $reservation)
            {
                start: '{{ $reservation }}',
                end: '{{ $reservation }}',
            },
        @endforeach
    ]);
    </script>
    @endpush
</x-app-layout>