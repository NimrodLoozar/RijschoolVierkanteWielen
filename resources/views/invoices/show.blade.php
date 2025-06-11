<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Factuur') }} #{{ $invoice->invoice_number }}
            </h2>
            <span class="px-3 py-1 text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full">
                {{ now()->format('d M Y') }}
            </span>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="bg-red-500 text-white p-4 rounded">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="bg-green-500 text-white p-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-lg rounded-lg p-6 border">
                
                <!-- Bedrijfs- en Klantinformatie -->
                <div class="grid grid-cols-2 gap-6 border-b pb-4">
                    <!-- Bedrijfsgegevens -->
                    <div>
                        <h3 class="text-lg font-bold">Rijschool:</h3>
                        <p>Rijschool Vierkante Wielen</p>
                        <p>Autolaan 123, 1234 AB Utrecht</p>
                        <p>KvK: 12345678</p>
                        <p>BTW-nummer: NL123456789B01</p>
                    </div>

                    <!-- Klantgegevens -->
                    <div>
                        <h3 class="text-lg font-bold">Klant:</h3>
                        <p>{{ $invoice->student_name ?? 'N/A' }}</p>
                        <p>Relatienummer: {{ $invoice->student_relation_number ?? 'N/A' }}</p>
                        
                        <p>Status: 
                            @if($invoice->student_is_active)
                                <span class="bg-green-500 text-white py-1 px-3 rounded-full text-xs font-semibold">Actief</span>
                            @else
                                <span class="bg-red-500 text-white py-1 px-3 rounded-full text-xs font-semibold">Inactief</span>
                            @endif
                        </p>
                    
                    </div>
                </div>

                <!-- Factuurgegevens -->
                <div class="mt-6">
                    <p><strong>Factuurnummer:</strong> #{{ $invoice->invoice_number }}</p>
                    <p><strong>Factuurdatum:</strong> {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d-m-Y') }}</p>
                    <p><strong>Begindatum:</strong> {{ \Carbon\Carbon::parse($invoice->start_date)->format('d-m-Y') }}</p>
                    <p><strong>Einddatum:</strong> {{ \Carbon\Carbon::parse($invoice->end_date)->format('d-m-Y') }}</p>

                    <p><strong>Status:</strong> 
                        @if($invoice->status == 'paid')
                            <span class="bg-green-500 text-white py-1 px-3 rounded-full text-xs font-semibold">Betaald</span>
                        @elseif($invoice->status == 'pending')
                            <span class="bg-yellow-400 text-white py-1 px-3 rounded-full text-xs font-semibold">In afwachting</span>
                        @else
                            <span class="bg-red-500 text-white py-1 px-3 rounded-full text-xs font-semibold">Onbetaald</span>
                        @endif
                    </p>
                </div>

                <!-- Lesdetails -->
                <div class="mt-6 border-t pt-4">
                    <h3 class="text-lg font-bold">Factuur details</h3>
                    <p><strong>Pakket type:</strong> {{ $invoice->package_type ?? 'N/A' }}</p>
                    <p><strong>Aantal lessen:</strong> {{ $invoice->lesson_count ?? 0 }}</p>
                    <p><strong>Prijs per les:</strong> € {{ number_format($invoice->price_per_lesson ?? 0, 2, ',', '.') }}</p>
                    <p><strong>Opmerking:</strong> {{ $invoice->note }}</p>
                </div>

                <!-- Bedragen -->
                <div class="mt-6 border-t pt-4">
                    <p><strong>Bedrag excl. BTW:</strong> € {{ number_format($invoice->amount_excl_vat, 2, ',', '.') }}</p>
                    <p><strong>BTW:</strong> € {{ number_format($invoice->vat, 2, ',', '.') }}</p>
                    <p class="text-xl font-bold"><strong>Totaal:</strong> € {{ number_format($invoice->amount_incl_vat, 2, ',', '.') }}</p>
                </div>
                
                <!-- Beheeropties -->
                @if(Auth::check())
                <div class="flex justify-between mt-6 border-t pt-6">
                    <div>
                        <a href="{{ route('invoices.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-md transition duration-300">
                            Terug naar overzicht
                        </a>
                    </div>
                    <div class="space-x-4">
                        <a href="{{ route('invoices.edit', $invoice->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md transition duration-300">Bewerken</a>
                        
                        <form method="POST" action="{{ route('invoices.destroy', $invoice->id) }}" class="inline" onsubmit="return confirm('Weet je zeker dat je deze factuur wilt verwijderen?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-md transition duration-300">Verwijderen</button>
                        </form>
                    </div>
                </div>
                @else
                <div class="flex justify-end mt-6 border-t pt-6">
                    <a href="{{ route('invoices.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md transition duration-300">
                        Terug naar overzicht
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>