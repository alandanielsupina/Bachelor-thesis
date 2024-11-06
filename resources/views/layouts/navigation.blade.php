<nav x-data="{ open: false }" class="bg-sky-600 border-b border-black">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 lg:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}">
                        {{--
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" /> --}}
                        <svg class="w-[39px] h-[39px] text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2.3"
                                d="M18.5 4h-13m13 16h-13M8 20v-3.333a2 2 0 0 1 .4-1.2L10 12.6a1 1 0 0 0 0-1.2L8.4 8.533a2 2 0 0 1-.4-1.2V4h8v3.333a2 2 0 0 1-.4 1.2L13.957 11.4a1 1 0 0 0 0 1.2l1.643 2.867a2 2 0 0 1 .4 1.2V20H8Z" />
                        </svg>
                    </a>
                </div>

                <!-- Navigation Links -->
                @auth
                {{-- <div class="hidden space-x-8 lg:-my-px lg:ml-10 lg:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div> --}}

                {{-- <div class="hidden space-x-8 lg:-my-px lg:ml-10 lg:flex">
                    <x-nav-link :href="route('food')" :active="request()->routeIs('food')">
                        {{ __('Food') }}
                        Navrhnované jedlo
                    </x-nav-link>
                </div> --}}

                @if (session()->get('foOrBo') === "bo")
                <div class="hidden space-x-8 lg:-my-px lg:ml-10 lg:flex">
                    <x-nav-link :href="route('fo.searching.select-city')"
                        :active="request()->routeIs('fo.searching.select-city')">
                        Pohľad zákazníka
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 lg:-my-px lg:ml-10 lg:flex">
                    <x-nav-link :href="route('bo.user-companies.all')"
                        :active="request()->routeIs('bo.user-companies.all')">
                        Podniky
                    </x-nav-link>
                </div>

                @if (session()->has('selected_company'))
                <div class="hidden space-x-8 lg:-my-px lg:ml-10 lg:flex">
                    <x-nav-link :href="route('bo.basic-informations.show')"
                        :active="request()->routeIs('bo.basic-informations.show')">
                        Základné informácie
                    </x-nav-link>
                </div>
                @endif

                @if (session()->has('selected_company'))
                <div class="hidden space-x-8 lg:-my-px lg:ml-10 lg:flex">
                    <x-nav-link :href="route('bo.schedules.show')" :active="request()->routeIs('bo.schedules.show')">
                        Otváracie hodiny
                    </x-nav-link>
                </div>
                @endif

                @if (session()->has('selected_company'))
                <div class="hidden space-x-8 lg:-my-px lg:ml-10 lg:flex">
                    <x-nav-link :href="route('bo.services.all')" :active="request()->routeIs('bo.services.all')">
                        Služby
                    </x-nav-link>
                </div>
                @endif

                @if (session()->has('selected_company'))
                <div class="hidden space-x-8 lg:-my-px lg:ml-10 lg:flex">
                    <x-nav-link :href="route('bo.reservations.all')"
                        :active="request()->routeIs('bo.reservations.all')">
                        Rezervácie
                    </x-nav-link>
                </div>
                @endif

                @else

                <div class="hidden space-x-8 lg:-my-px lg:ml-10 lg:flex">
                    <x-nav-link :href="route('fo.searching.select-city')"
                        :active="request()->routeIs('fo.searching.select-city')">
                        Rezervovať
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 lg:-my-px lg:ml-10 lg:flex">
                    <x-nav-link :href="route('fo.reservations.show-calendar')"
                        :active="request()->routeIs('fo.reservations.show-calendar')">
                        Moje rezervácie
                    </x-nav-link>
                </div>

                {{-- Sem ešte pribudne pre prihlásených, že si môžu prezerať svoje rezervácie --}}

                @if(Auth::user()->hasRole('super-admin') || Auth::user()->hasRole('owner'))
                <div class="hidden space-x-8 lg:-my-px lg:ml-10 lg:flex">
                    <x-nav-link :href="route('bo.user-companies.all')"
                        :active="request()->routeIs('bo.user-companies.all')">
                        Spravovať podniky
                    </x-nav-link>
                </div>
                @endif

                @endif





                {{-- <div class="hidden space-x-8 lg:-my-px lg:ml-10 lg:flex">
                    <x-nav-link :href="route('new_companies.create')"
                        :active="request()->routeIs('new_companies.create')">
                        Vytvoriť podnik
                    </x-nav-link>
                </div> --}}

                {{-- <div class="hidden space-x-8 lg:-my-px lg:ml-10 lg:flex">
                    <x-nav-link :href="route('new_all_workers')" :active="request()->routeIs('new_all_workers')">
                        Všetci pracovníci
                    </x-nav-link>
                </div> --}}

                {{-- <div class="hidden space-x-8 lg:-my-px lg:ml-10 lg:flex">
                    <x-nav-link :href="route('new_workers.create')" :active="request()->routeIs('new_workers.create')">
                        Vytvoriť pracovníka
                    </x-nav-link>
                </div> --}}
                @else
                {{-- TODO: add more web sites for guest --}}
                <div class="hidden space-x-8 lg:-my-px lg:ml-10 lg:flex">
                    <x-nav-link :href="route('fo.searching.select-city')"
                        :active="request()->routeIs('fo.searching.select-city')">
                        Rezervovať
                    </x-nav-link>
                </div>
                @endauth
            </div>

            @guest
            <div class="flex">
                <!-- Navigation Links -->
                <div class="hidden space-x-8 lg:-my-px lg:ml-10 lg:flex">
                    <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                        {{ __('Login') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 lg:-my-px lg:ml-10 lg:flex">
                    <x-nav-link :href="route('register')" :active="request()->routeIs('login')">
                        {{ __('Sing up') }}
                    </x-nav-link>
                </div>
            </div>
            @endguest



            <!-- Settings Dropdown -->
            @auth
            <div class="hidden lg:flex lg:items-center lg:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-sky-600 hover:text-black hover:font-bold focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profil
                        </x-dropdown-link>

                        @if(Auth::user()->hasRole('super-admin'))
                        <x-dropdown-link :href="route('bo.users.all')">
                            Používatelia
                        </x-dropdown-link>
                        @endif

                        @if(Auth::user()->hasRole('super-admin'))
                        <x-dropdown-link :href="route('bo.all-companies.all')">
                            Všetky podniky
                        </x-dropdown-link>
                        @endif

                        @if(Auth::user()->hasRole('super-admin'))
                        <x-dropdown-link :href="route('bo.categories.all')">
                            Kategórie
                        </x-dropdown-link>
                        @endif

                        @if(Auth::user()->hasRole('super-admin'))
                        <x-dropdown-link :href="route('bo.reservation-management.all')">
                            Manažmenť rezervácií
                        </x-dropdown-link>
                        @endif

                        {{-- <x-dropdown-link :href="route('food')">
                            Navrhnované jedlo
                        </x-dropdown-link> --}}

                        {{-- <x-dropdown-link :href="route('bo.users.all')">
                            Všetci používatelia
                        </x-dropdown-link> --}}

                        {{-- <x-dropdown-link :href="route('new_companies.create')">
                            Vytvoriť podnik
                        </x-dropdown-link> --}}

                        {{-- <x-dropdown-link :href="route('new_all_workers')">
                            Všetci pracovníci
                        </x-dropdown-link> --}}

                        {{-- <x-dropdown-link :href="route('new_workers.create')">
                            Vytvoriť pracovníka
                        </x-dropdown-link> --}}

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                Odhlásiť sa
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            @endauth

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center lg:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-white hover:bg-sky-500 focus:outline-none focus:bg-sky-500 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- toto menu sa zobrazi na telefone (nie na vacsej obrazovke) -->
    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden">
        @auth
        {{-- <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div> --}}

        {{--
        <!-- hento :active= by malo spravit to, ze zostane zvyraznene Food v menu, pokial budeme na Food podstranke -->
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('food')" :active="request()->routeIs('food')">
                Navrhnované jedlo
            </x-responsive-nav-link>
        </div> --}}

        {{-- TODO: pridať ďalšie pre zobranie mobilu --}}
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('bo.users.all')" :active="request()->routeIs('bo.users.all')">
                Všetci používatelia
            </x-responsive-nav-link>
        </div>

        {{-- <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('new_companies.create')"
                :active="request()->routeIs('new_companies.create')">
                Vytvoriť podnik
            </x-responsive-nav-link>
        </div> --}}



        {{-- <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('new_all_workers')" :active="request()->routeIs('new_all_workers')">
                Všetci pracovníci
            </x-responsive-nav-link>
        </div> --}}

        {{-- <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('new_workers.create')"
                :active="request()->routeIs('new_workers.create')">
                Vytvoriť pracovníka
            </x-responsive-nav-link>
        </div> --}}

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-black">
            <div class="px-4">
                <div class="font-bold text-base text-black">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-black">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                {{-- <x-responsive-nav-link :href="route('food')">
                    Navrhnované jedlo
                </x-responsive-nav-link> --}}

                {{-- <x-responsive-nav-link :href="route('bo.users.all')">
                    Všetci používatelia
                </x-responsive-nav-link> --}}

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @else
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                {{ __('Login') }}
            </x-responsive-nav-link>
        </div>

        <!-- hento :active= by malo spravit to, ze zostane zvyraznene Food v menu, pokial budeme na Food podstranke -->
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">
                {{ __('Sing up') }}
            </x-responsive-nav-link>
        </div>
        {{-- TODO: add more web sites for guest on mobile phone--}}
        @endauth
    </div>
</nav>