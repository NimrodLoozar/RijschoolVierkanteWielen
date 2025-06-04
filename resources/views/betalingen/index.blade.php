<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Betalingen Overzicht
        </h2>
        <label class="flex items-center">
            <span class="mr-2 text-gray-900 dark:text-gray-200">Toon Data</span>
            <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                <input type="checkbox" id="dataToggle"
                    class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"
                    checked />
                <label for="dataToggle"
                    class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
            </div>
        </label>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Add success message display --}}
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <a href="{{ route('betalingen.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-blue-700 mb-4">
                Nieuwe Betaling
            </a>

            @if($payments->isEmpty())
                <div id="noPaymentsError"
                    class="bg-red-600 px-4 py-4 rounded relative dark:bg-red-800 dark:border-red-400 text-red-100">
                    Geen betalingen gevonden. Probeer later opnieuw of voeg betalingen toe.
                </div>
            @else
                <div id="dataContainer" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <table class="w-full min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Factuurnummer
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Datum
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Notitie
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @foreach($payments as $payment)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $payment->invoice_number ?? 'Niet beschikbaar' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ \Carbon\Carbon::parse($payment->date)->format('d-m-Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $payment->status === 'paid' ? 'bg-green-100 text-green-800' : 
                                                   ($payment->status === 'open' ? 'bg-yellow-100 text-yellow-800' : 
                                                   'bg-red-100 text-red-800') }}">
                                                {{ $payment->status === 'paid' ? 'Betaald' : 
                                                   ($payment->status === 'open' ? 'Openstaand' : 
                                                   'Geannuleerd') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $payment->description ?? '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <div id="errorContainer"
                class="hidden ml-64 bg-red-600 px-4 py-4 rounded relative dark:bg-red-800 dark:border-red-400 text-red-100 mt-4">
                Er is een fout opgetreden bij het laden van de betalingen.
            </div>

        </div>
    </div>

    <script>
        document.getElementById('dataToggle').addEventListener('change', function () {
            const dataContainer = document.getElementById('dataContainer');
            const noPaymentsError = document.getElementById('noPaymentsError');
            const errorContainer = document.getElementById('errorContainer');

            if (this.checked) {
                if (dataContainer) dataContainer.classList.remove('hidden');
                if (noPaymentsError) noPaymentsError.classList.add('hidden');
                errorContainer.classList.add('hidden');
            } else {
                if (dataContainer) dataContainer.classList.add('hidden');
                if (noPaymentsError) noPaymentsError.classList.remove('hidden');
                errorContainer.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
