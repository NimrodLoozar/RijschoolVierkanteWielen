<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Betalingen Overzicht
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($payments->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-gray-600">Er zijn nog geen betalingen geregistreerd.</p>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <table class="min-w-full table-auto border-collapse border border-gray-200">
                        <thead>
                            <tr>
                                <th class="border border-gray-300 px-4 py-2">ID</th>
                                <th class="border border-gray-300 px-4 py-2">Factuurnummer</th>
                                <th class="border border-gray-300 px-4 py-2">Datum</th>
                                <th class="border border-gray-300 px-4 py-2">Status</th>
                                <th class="border border-gray-300 px-4 py-2">Notitie</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">{{ $payment->id }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $payment->invoice_id }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $payment->date->format('d-m-Y') }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ ucfirst($payment->status) }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $payment->note }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
