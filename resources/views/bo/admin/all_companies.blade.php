<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Všetky podniky
        </h2>
    </x-slot>


    <div class="my-10 lg:mx-5">
        @if (!$companies->isEmpty())
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-black dark:text-blue-100">
                <thead class="text-xs text-white uppercase bg-gray-400 dark:text-white">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            id
                        </th>
                        <th scope="col" class="px-6 py-3">
                            id používateľa
                        </th>
                        <th scope="col" class="px-6 py-3">
                            názov
                        </th>
                        <th scope="col" class="px-6 py-3">
                            mesto
                        </th>
                        <th scope="col" class="px-6 py-3">
                            adresa
                        </th>
                        <th scope="col" class="px-6 py-3">
                            aktívny
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
                    @foreach ($companies as $company)
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
                        <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap dark:text-blue-100">
                            {{ $company->id }}
                        </th>
                        <td class="px-6 py-4">
                            <a id="bo-users-all-edit" class="p-3 font-medium cursor-pointe hover:underline"
                                href="{{ route('bo.users.edit', $company->user->id) }}">{{ $company->user->id }}</a>
                        </td>
                        <td class="px-6 py-4">
                            {{ $company->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $company->city }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $company->address }}
                        </td>
                        @if ($company->active === 1)
                        <td class="px-6 py-4">
                            Áno
                        </td>
                        @else
                        <td class="px-6 py-4">
                            Nie
                        </td>
                        @endif
                        <td class="px-6 py-4">
                            {{ $company->created_at }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $company->updated_at }}
                        </td>
                        @if ($company->deleted_at === NULL)
                        <td class="px-6 py-4">
                            XXX
                        </td>
                        @else
                        <td class="px-6 py-4">
                            {{ $company->deleted_at }}
                        </td>
                        @endif
                        <td class="px-6 py-4 text-base">
                            @if ($company->deleted_at === NULL)
                            {{-- select-company --}}
                            <form id="bo-all-companies-all-select-company" method="post"
                                action="{{ route('bo.all-companies.select-company', $company->id) }}"
                                class="font-medium cursor-pointer hover:underline">
                                @csrf
                                <input type="submit" value="Zvoliť" class="cursor-pointer hover:underline">
                            </form>
                            @else
                            {{-- restore --}}
                            <form id="bo-all-companies-all-restore" method="post"
                                action="{{ route('bo.all-companies.restore', $company->id) }}"
                                class="font-medium cursor-pointer hover:underline">
                                @csrf
                                <input type="submit" value="Obnoviť" class="cursor-pointer hover:underline">
                            </form>
                            @endif
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
        <h1 class="text-3xl mb-4 mt-10 font-bold text-red-600 text-center">Žiadne podniky</h1>
        @endif
    </div>
</x-app-layout>