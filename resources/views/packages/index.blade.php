<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Overzicht van de lespakketten') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (count($packages) > 0)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 hidden md:block">
                        <table class="w-full min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Pakketten
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Aantal lessen
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Prijs per les
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Actief
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Informatie
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @foreach ($packages as $package)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-700 dark:text-blue-500">
                                            {{ ucfirst($package->type) }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $package->lesson_count }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            €{{ number_format($package->price_per_lesson, 2) }}
                                        </td>
                                        @if ($package->is_active)
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-green-500 dark:text-green-400">
                                                <span
                                                    class="text-gray-900 dark:text-gray-100 bg-green-500/70 rounded-xl px-2 py-1">
                                                    {{ $package->is_active ? 'Ja' : 'Nee' }}
                                                </span>
                                            </td>
                                        @endif
                                        @if (!$package->is_active)
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-red-500 dark:text-red-400">
                                                <span
                                                    class="text-gray-900 dark:text-gray-100 bg-red-500/70 rounded-xl px-2 py-1">
                                                    {{ $package->is_active ? 'Ja' : 'Nee' }}
                                                </span>
                                            </td>
                                        @endif
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-40 sm:truncate sm:max-w-0">
                                            {{ $package->note ?? 'Geen opmerking' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:hidden">
                    @foreach ($packages as $package)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <h3 class="text-lg font-bold mb-2">{{ ucfirst($package->type) }}</h3>
                                <p>Aantal lessen: {{ $package->lesson_count }}</p>
                                <p>Prijs per les: €{{ number_format($package->price_per_lesson, 2) }}</p>
                                @if ($package->is_active)
                                    <p class="text-sm text-green-500 dark:text-green-400">
                                        Actief: {{ $package->is_active ? 'Ja' : 'Nee' }}</p>
                                    </p>
                                @endif
                                @if (!$package->is_active)
                                    <p class="text-sm text-red-500 dark:text-red-400">
                                        Actief: {{ $package->is_active ? 'Ja' : 'Nee' }}</p>
                                    </p>
                                @endif
                                <p>Opmerking: {{ $package->note ?? 'Geen opmerking' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="w-full bg-red-600 px-4 py-4 rounded relative dark:bg-red-800 dark:border-red-400"
                    role="alert">
                    <span class="block sm:inline text-red-500 dark:text-gray-100">Geen lespakketten gevonden. Voeg
                        pakketten toe of probeer later opnieuw.</span>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
