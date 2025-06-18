<x-app-layout>
        <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Facturen') }}
            </h2>
            <span class="px-3 py-1 text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full">
                {{ now()->format('d M Y') }}
            </span>
        </div>
    </x-slot>
    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
            <br>
            <div class="flex flex-col space-y-4 md:space-y-0 md:flex-row md:items-center md:space-x-4">
                <!-- Compact Search Form -->
                <div class="w-full md:w-auto">
                    <button id="toggleFilters" class="flex items-center text-blue-600 mb-2 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                        </svg>
                        Filters {{ isset($searchInvoiceNumber) || isset($searchCustomer) || isset($searchStatus) || isset($searchDateFrom) || isset($searchDateTo) ? '(Actief)' : '' }}
                    </button>
                    
                    <div id="filterSection" class="{{ isset($searchInvoiceNumber) || isset($searchCustomer) || isset($searchStatus) || isset($searchDateFrom) || isset($searchDateTo) ? '' : 'hidden' }} bg-gray-50 p-3 rounded-md mb-3">
                        <form method="GET" action="{{ route('invoices.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
                            <div>
                                <input type="text" name="searchInvoiceNumber" id="searchInvoiceNumber" placeholder="Factuurnummer" value="{{ $searchInvoiceNumber ?? '' }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-600 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div>
                                <input type="text" name="searchCustomer" id="searchCustomer" placeholder="Klant" value="{{ $searchCustomer ?? '' }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-600 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div>
                                <select name="searchStatus" id="searchStatus" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-600 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">Alle statussen</option>
                                    <option value="Betaald" {{ isset($searchStatus) && $searchStatus == 'Betaald' ? 'selected' : '' }}>Betaald</option>
                                    <option value="Onbetaald" {{ isset($searchStatus) && $searchStatus == 'Onbetaald' ? 'selected' : '' }}>Onbetaald</option>
                                </select>
                            </div>
                            <div>
                                <input type="date" name="searchDateFrom" id="searchDateFrom" placeholder="Datum vanaf" value="{{ $searchDateFrom ?? '' }}" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-600 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div>
                                <input type="date" name="searchDateTo" id="searchDateTo" placeholder="Datum tot" value="{{ $searchDateTo ?? '' }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-600 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div class="flex gap-2 items-center">
                                <button type="submit" class="flex-1 bg-blue-500 text-white px-3 py-2 rounded-md hover:bg-blue-600">
                                    Zoeken
                                </button>
                                @if(isset($searchInvoiceNumber) || isset($searchCustomer) || isset($searchStatus) || isset($searchDateFrom) || isset($searchDateTo))
                                    <a href="{{ route('invoices.index') }}" class="flex-1 bg-gray-500 text-white px-3 py-2 rounded-md hover:bg-gray-600 text-center">
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <div class="flex-grow"></div>
                <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-4">
                    <label class="flex items-center">
                        <span class="mr-2 text-white !important" style="color: white !important;">Toon Data</span>
                        <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                            <input type="checkbox" id="dataToggle"
                                class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"
                                checked />
                            <label for="dataToggle"
                                class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                        </div>
                    </label>
                    <a href="{{ route('invoices.create') }}" class="w-full sm:w-auto text-center bg-blue-600 text-white px-5 py-3 rounded-md transition duration-300 hover:bg-green-700 transform hover:scale-105">Factuur Aanmaken</a>
                </div>
            </div>
        </div>

        <div id="dataContainer">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row gap-8">
                    <div class="w-full overflow-x-auto">
                        <div class="bg-white shadow-lg rounded-lg my-6">
                            @if (isset($paginatedInvoices) && count($paginatedInvoices) > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full table-auto">
                                        <thead>
                                            <tr class="bg-gray-100 text-gray-800 uppercase text-sm font-medium leading-normal">
                                                <th class="py-4 px-2 sm:px-6 text-left">Factuurnummer</th>
                                                <th class="py-4 px-2 sm:px-6 text-left">Klant</th>
                                                <th class="py-4 px-2 sm:px-6 text-left hidden sm:table-cell">Datum</th>
                                                <th class="py-4 px-2 sm:px-6 text-left">Bedrag</th>
                                                <th class="py-4 px-2 sm:px-6 text-left">Status</th>
                                                <th class="py-4 px-2 sm:px-6 text-left hidden sm:table-cell">Lessen</th>
                                                <th class="py-4 px-2 sm:px-6 text-center">Acties</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-gray-800 text-sm font-light">
                                            @foreach ($paginatedInvoices as $invoice)
                                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                    <td class="py-3 px-2 sm:px-6 truncate max-w-[100px] sm:max-w-none">{{ $invoice->invoice_number }}</td>
                                                    <td class="py-3 px-2 sm:px-6 truncate max-w-[100px] sm:max-w-none">{{ $invoice->student_name }}</td>
                                                    <td class="py-3 px-2 sm:px-6 hidden sm:table-cell">{{ date('d-m-Y', strtotime($invoice->invoice_date)) }}</td>
                                                    <td class="py-3 px-2 sm:px-6">€ {{ number_format($invoice->amount_incl_vat, 2, ',', '.') }}</td>
                                                    <td class="py-3 px-2 sm:px-6">
                                                        <span class="{{ $invoice->status == 'Betaald' ? 'text-green-500 bg-green-100' : 'text-red-500 bg-red-100' }} py-1 px-2 sm:px-3 rounded-full text-xs font-medium">
                                                            {{ $invoice->status }}
                                                        </span>
                                                    </td>
                                                    <td class="py-3 px-2 sm:px-6 hidden sm:table-cell">{{ $invoice->lesson_count ?? 0 }}</td>
                                                    <td class="py-3 px-2 sm:px-6 flex justify-center space-x-1 sm:space-x-2">
                                                        <a href="{{ route('invoices.show', $invoice->id) }}" class="text-blue-500 hover:underline p-1" title="Details bekijken">ⓘ</a>
                                                        <a href="{{ route('invoices.edit', $invoice->id) }}" class="text-yellow-500 hover:underline p-1" title="Bewerken">✎</a>
                                                        @if($invoice->status != 'Betaald')
                                                            <a href="{{ route('invoices.markAsPaid', $invoice->id) }}" class="text-green-500 hover:underline p-1" title="Markeren als betaald">✓</a>
                                                        @endif
                                                        @if($invoice->status != 'Onbetaald')
                                                            <a href="{{ route('invoices.markAsUnpaid', $invoice->id) }}" class="text-red-500 hover:underline p-1" title="Markeren als onbetaald">✗</a>
                                                        @endif
                                                        <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" class="delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-500 hover:underline p-1" title="Verwijderen">🗑️</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-red-500 p-6 text-center mx-auto">Geen facturen gevonden.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    @if(isset($paginatedInvoices) && method_exists($paginatedInvoices, 'links'))
                        {{ $paginatedInvoices->appends(request()->query())->links() }}
                    @endif
                </div>
            </div>
        </div>

        <div id="errorContainer" class="py-12 hidden text-center mx-auto">
            <p class="text-red-500">Geen facturen gevonden. Maak een nieuwe factuur aan.</p>
        </div>
    </div>
</x-layout>

<script>
    document.getElementById('dataToggle').addEventListener('change', function() {
        const dataContainer = document.getElementById('dataContainer');
        const errorContainer = document.getElementById('errorContainer');
        if (this.checked) {
            dataContainer.classList.remove('hidden');
            errorContainer.classList.add('hidden');
        } else {
            dataContainer.classList.add('hidden');
            errorContainer.classList.remove('hidden');
        }
    });

    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (confirm('i.v.m. privacy mogen facturen binnen de 7 jaren niet verwijderd worden. Weet je zeker dat je deze factuur permanent wilt verwijderen? Dit kan niet ongedaan worden gemaakt!')) {
                this.submit();
            }
        });
    });

    // Toggle filter section
    document.getElementById('toggleFilters').addEventListener('click', function() {
        const filterSection = document.getElementById('filterSection');
        filterSection.classList.toggle('hidden');
    });
</script>

<style>
    h2 {
        color: #fff;
    }

    .toon {
        color: #fff;
    }

    .toggle-checkbox:checked {
        right: 0;
        border-color: #38A169;
    }

    .toggle-checkbox:checked+.toggle-label {
        background-color: #38A169;
    }

    .overflow-x-auto {
        overflow-x: auto;
    }
    
    @media (max-width: 640px) {
        table {
            font-size: 0.8rem;
        }
        
        .toggle-checkbox {
            transform: scale(0.9);
        }
        
        input[type="text"], input[type="date"], select {
            padding: 0.4rem;
            min-width: unset;
            width: 100%;
        }
    }
    
    input[type="text"], input[type="date"], select {
        padding: 0.5rem;
    }
</style>