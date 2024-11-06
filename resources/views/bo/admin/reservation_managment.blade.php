<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dnešné rezervácie
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="my-10">
            <form method="post" action="{{ route('bo.reservation-management.send-notifications') }}">
                @csrf
                <div class="flex mr-5 sm:mr-0 items-center mt-4">
                    <button type="submit"
                        class="text-white bg-sky-400 hover:bg-sky-500 focus:ring-4 focus:ring-sky-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Poslať notifikácie</button>
                </div>
            </form>

            @if (!$reservations->isEmpty())
            <div class="mt-4 grid lg:grid-cols-2 xl:grid-cols-3 lg:justify-center">
                @foreach ($reservations as $reservation)
                <div class="flex justify-center">
                    <div class="font-medium text-white max-w-sm w-full">
                        <div
                            class="no-underline mb-5 block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{
                                $reservation->service->name }}</h5>
                            <h6 class="inline mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white">
                                {{
                                $reservation->start_at }}</h6>
                            <a href="{{ route('bo.users.edit', $reservation->user->id) }}">
                                <h6
                                    class="inline mb-2 ml-5 text-lg font-bold tracking-tight text-gray-900 dark:text-white">
                                    {{
                                    $reservation->user->name }}</h6>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <h1 class="text-3xl mb-4 mt-10 font-bold text-red-600 text-center">Žiadne rezervácie na dnešný deň</h1>
            @endif



        </div>
    </div>
</x-app-layout>