<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Overzicht van de auto\'s') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (count($autos) > 0)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 hidden md:block">
                        <table class="w-full min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Merk
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider hidden xl:table-cell">
                                        Model
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider hidden lg:table-cell">
                                        Kenteken
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Brandstof
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Actief
                                    </th>
                                    {{-- 
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Foto
                                    </th>
                                    --}}
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @foreach ($autos as $auto)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-700 dark:text-blue-500">
                                            {{ $auto->brand }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 hidden xl:table-cell">
                                            {{ $auto->model }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 hidden lg:table-cell">
                                            {{ $auto->license_plate }}
                                        </td>
                                        {{-- <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ ucfirst($auto->fuel) }}
                                        </td> --}}
                                        @if ($auto->fuel === 'gasoline')
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-yellow-500 dark:text-yellow-400">
                                                {{ ucfirst($auto->fuel) }}
                                            </td>
                                        @endif
                                        @if ($auto->fuel === 'electric')
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-green-500 dark:text-green-400">
                                                {{ ucfirst($auto->fuel) }}
                                            </td>
                                        @endif
                                        @if ($auto->is_active)
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-green-500 dark:text-green-400">
                                                <span
                                                    class="text-gray-900 dark:text-gray-100 bg-green-500/70 rounded-xl px-2 py-1">
                                                    {{ $auto->is_active ? 'Ja' : 'Nee' }}
                                                </span>
                                            </td>
                                        @endif
                                        @if (!$auto->is_active)
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-red-500 dark:text-red-400">
                                                <span
                                                    class="text-gray-900 dark:text-gray-100 bg-red-500/70 rounded-xl px-2 py-1">
                                                    {{ $auto->is_active ? 'Ja' : 'Nee' }}
                                                </span>
                                            </td>
                                        @endif
                                        {{--
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            @if ($auto->photo)
                                                <img src="{{ asset($auto->photo) }}" alt="Foto van {{ $auto->brand }}"
                                                    width="100">
                                            @else
                                                Geen foto beschikbaar
                                            @endif
                                        </td>
                                        --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:hidden">
                    @foreach ($autos as $auto)
                        <div
                            class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 flex flex-col">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                    {{ $auto->brand }} {{ $auto->model }}
                                </h3>
                                @if ($auto->fuel === 'gasoline')
                                    <span
                                        class="text-sm text-yellow-500 dark:text-yellow-400">{{ ucfirst($auto->fuel) }}</span>
                                @endif
                                @if ($auto->fuel === 'electric')
                                    <span
                                        class="text-sm text-green-500 dark:text-green-400">{{ ucfirst($auto->fuel) }}</span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Kenteken: {{ $auto->license_plate }}
                            </p>
                            @if ($auto->is_active)
                                <p class="text-sm text-green-500 dark:text-green-400">
                                    Actief: {{ $auto->is_active ? 'Ja' : 'Nee' }}</p>
                                </p>
                            @endif
                            @if (!$auto->is_active)
                                <p class="text-sm text-red-500 dark:text-red-400">
                                    Actief: {{ $auto->is_active ? 'Ja' : 'Nee' }}</p>
                                </p>
                            @endif
                            {{--
                            @if ($auto->photo)
                                <img src="{{ asset($auto->photo) }}" alt="Foto van {{ $auto->brand }}" width="100"
                                    class="mt-2">
                            @else
                                Geen foto beschikbaar
                            @endif
                            --}}
                        </div>
                    @endforeach
                </div>
            @else
                <div class="w-full bg-red-600 px-4 py-4 rounded relative dark:bg-red-800 dark:border-red-400"
                    role="alert">
                    <span class="block sm:inline text-red-500 dark:text-gray-100">Geen auto's gevonden. Probeer later
                        opnieuw of voeg auto's toe.</span>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
