<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Upravenie používateľa {{ $user->name }}
        </h2>
    </x-slot>

    <div class="mt-10 flex flex-col items-center">
        <div class="w-full sm:max-w-md">
            <a class="ml-5 sm:ml-0 inline-block rounded-full border border-sky-400 bg-sky-400 p-3 text-white hover:bg-transparent hover:text-sky-400 focus:outline-none focus:ring active:text-sky-400"
                href="{{ route('bo.users.all') }}">
                <span class="sr-only"> Naspäť </span>

                <svg class="size-5 rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>

            @if ( session()->has('success-others'))
            <div class="mb-5 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 " role="alert">
                <p class="font-bold">{{ session()->get('success-others') }}</p>
            </div>
            @endif

            <form id="bo-users-update-others" class="mb-10" method="post"
                action="{{ route('bo.users.update-others', $user->id) }}">
                @csrf
                @method('put')
                <!-- Name -->
                <div>
                    <label for="name" class="text-lg font-bold mb-2">Meno</label>
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$user->name"
                        autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <label for="email" class="text-lg font-bold mb-2">E-mail</label>
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="$user->email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex mr-5 sm:mr-0 items-center justify-end mt-4">
                    <button type="submit"
                        class="text-white bg-sky-400 hover:bg-sky-500 focus:ring-4 focus:ring-sky-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Potvrdiť</button>
                </div>
            </form>

            @if ( session()->has('success-password'))
            <div class="mb-5 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 " role="alert">
                <p class="font-bold">{{ session()->get('success-password') }}</p>
            </div>
            @endif

            <form id="bo-users-update-password" class="mb-10" method="post"
                action="{{ route('bo.users.update-password', $user->id) }}">
                @csrf
                @method('put')
                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="text-lg font-bold mb-2">Heslo</label>
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex mr-5 sm:mr-0 items-center justify-end mt-4">
                    <button type="submit"
                        class="text-white bg-sky-400 hover:bg-sky-500 focus:ring-4 focus:ring-sky-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Potvrdiť</button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>