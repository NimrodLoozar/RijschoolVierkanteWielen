<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Factuur bijwerken') }} #{{ $invoice->invoice_number }}
            </h2>
            <span class="px-3 py-1 text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full">
                {{ now()->format('d M Y') }}
            </span>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="bg-red-500 text-white p-4 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="container mx-auto px-4 py-8">
                <div class="max-w-4xl mx-auto">
                    <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-gray-100">
                        <div class="p-6 bg-white">
                            <h2 class="text-2xl font-semibold text-gray-800 mb-6 pb-2 border-b border-gray-200">Factuur bewerken</h2>

                            <form method="POST" action="{{ route('invoices.update', $invoice->id) }}">
                                @csrf
                                @method('PATCH')

                                <!-- Factuur informatie section -->
                                <div class="mb-8 bg-gray-50 p-5 rounded-lg shadow-sm">
                                    <h3 class="text-lg font-medium text-gray-800 mb-4 pb-2 border-b-2 border-gray-200">Factuur informatie</h3>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Factuur nummer -->
                                        <div class="mb-3">
                                            <label for="invoice_number" class="block text-sm font-medium text-gray-700 mb-1">Factuurnummer</label>
                                            <input type="text" name="invoice_number" id="invoice_number" 
                                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 @error('invoice_number') border-red-500 @enderror" 
                                                value="{{ old('invoice_number', $invoice->invoice_number) }}" readonly>
                                            @error('invoice_number')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Factuurdatum -->
                                        <div class="mb-3">
                                            <label for="invoice_date" class="block text-sm font-medium text-gray-700 mb-1">Factuurdatum</label>
                                            <input type="date" name="invoice_date" id="invoice_date" 
                                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 @error('invoice_date') border-red-500 @enderror" 
                                                value="{{ old('invoice_date', $invoice->invoice_date ? date('Y-m-d', strtotime($invoice->invoice_date)) : '') }}" required>
                                            @error('invoice_date')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Bedrag informatie section -->
                                <div class="mb-8 bg-gray-50 p-5 rounded-lg shadow-sm">
                                    <h3 class="text-lg font-medium text-gray-800 mb-4 pb-2 border-b-2 border-gray-200">Bedrag informatie</h3>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                        <!-- Bedrag (excl. BTW) -->
                                        <div class="mb-3">
                                            <label for="amount_excl_vat" class="block text-sm font-medium text-gray-700 mb-1">Bedrag (excl. BTW)</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500 sm:text-sm">€</span>
                                                </div>
                                                <input type="number" step="0.01" name="amount_excl_vat" id="amount_excl_vat" 
                                                    class="w-full pl-7 px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 @error('amount_excl_vat') border-red-500 @enderror" 
                                                    value="{{ old('amount_excl_vat', $invoice->amount_excl_vat) }}" required>
                                            </div>
                                            @error('amount_excl_vat')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- BTW bedrag -->
                                        <div class="mb-3">
                                            <label for="vat" class="block text-sm font-medium text-gray-700 mb-1">BTW bedrag</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500 sm:text-sm">€</span>
                                                </div>
                                                <input type="number" step="0.01" name="vat" id="vat" 
                                                    class="w-full pl-7 px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 @error('vat') border-red-500 @enderror" 
                                                    value="{{ old('vat', $invoice->vat) }}" required>
                                            </div>
                                            @error('vat')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Bedrag inclusief BTW -->
                                        <div class="mb-3">
                                            <label for="amount_incl_vat" class="block text-sm font-medium text-gray-700 mb-1">Bedrag (incl. BTW)</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500 sm:text-sm">€</span>
                                                </div>
                                                <input type="number" step="0.01" name="amount_incl_vat" id="amount_incl_vat" 
                                                    class="w-full pl-7 px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 @error('amount_incl_vat') border-red-500 @enderror" 
                                                    value="{{ old('amount_incl_vat', $invoice->amount_incl_vat) }}" required>
                                            </div>
                                            @error('amount_incl_vat')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Status informatie section -->
                                <div class="mb-8 bg-gray-50 p-5 rounded-lg shadow-sm">
                                    <h3 class="text-lg font-medium text-gray-800 mb-4 pb-2 border-b-2 border-gray-200">Status informatie</h3>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Status -->
                                        <div class="mb-3">
                                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                            <select name="status" id="status" 
                                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 @error('status') border-red-500 @enderror" required>
                                                <option value="pending" {{ old('status', $invoice->status) == 'pending' ? 'selected' : '' }}>Nog niet betaald</option>
                                                <option value="paid" {{ old('status', $invoice->status) == 'paid' ? 'selected' : '' }}>Betaald</option>
                                                <option value="overdue" {{ old('status', $invoice->status) == 'overdue' ? 'selected' : '' }}>Te laat</option>
                                                <option value="cancelled" {{ old('status', $invoice->status) == 'cancelled' ? 'selected' : '' }}>Geannuleerd</option>
                                            </select>
                                            @error('status')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Actief -->
                                        <div class="mb-3">
                                            <label for="is_active" class="block text-sm font-medium text-gray-700 mb-1">Activiteitsstatus</label>
                                            <select name="is_active" id="is_active" 
                                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 @error('is_active') border-red-500 @enderror" required>
                                                <option value="1" {{ old('is_active', $invoice->is_active) == 1 ? 'selected' : '' }}>Actief</option>
                                                <option value="0" {{ old('is_active', $invoice->is_active) == 0 ? 'selected' : '' }}>Inactief</option>
                                            </select>
                                            @error('is_active')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Extra informatie section -->
                                <div class="mb-8 bg-gray-50 p-5 rounded-lg shadow-sm">
                                    <h3 class="text-lg font-medium text-gray-800 mb-4 pb-2 border-b-2 border-gray-200">Extra informatie</h3>
                                    
                                    <!-- Opmerkingen -->
                                    <div class="mb-3">
                                        <label for="note" class="block text-sm font-medium text-gray-700 mb-1">Opmerkingen</label>
                                        <textarea name="note" id="note" rows="3" 
                                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 @error('note') border-red-500 @enderror"
                                            placeholder="Voeg hier eventuele opmerkingen toe...">{{ old('note', $invoice->note) }}</textarea>
                                        @error('note')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Factuur overzicht section -->
                                <div class="mb-8">
                                    <h3 class="text-lg font-medium text-gray-800 mb-4 pb-2 border-b-2 border-gray-200">Factuur overzicht</h3>
                                    <div class="bg-blue-50 p-5 rounded-lg border border-blue-100 shadow-sm">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <p class="mb-2 text-sm"><span class="font-medium text-gray-700">Factuursnummer:</span> 
                                                    <span class="text-blue-700">{{ $invoice->invoice_number }}</span>
                                                </p>
                                                <p class="mb-2 text-sm"><span class="font-medium text-gray-700">Klant:</span> 
                                                    <span class="text-blue-700">
                                                    @if(isset($invoice->student_name))
                                                        {{ $invoice->student_name }}
                                                    @else
                                                        Onbekend
                                                    @endif
                                                    </span>
                                                </p>
                                            </div>
                                            <div>
                                                <p class="mb-2 text-sm"><span class="font-medium text-gray-700">Aangemaakt op:</span> 
                                                    <span class="text-blue-700">
                                                    @if(isset($invoice->created_at))
                                                        {{ \Carbon\Carbon::parse($invoice->created_at)->format('d-m-Y H:i') }}
                                                    @else
                                                        Onbekend
                                                    @endif
                                                    </span>
                                                </p>
                                                <p class="mb-2 text-sm"><span class="font-medium text-gray-700">Status:</span> 
                                                    <span class="text-blue-700">
                                                    @if($invoice->status == 'pending')
                                                        Nog niet betaald
                                                    @elseif($invoice->status == 'paid')
                                                        Betaald
                                                    @elseif($invoice->status == 'overdue')
                                                        Te laat
                                                    @elseif($invoice->status == 'cancelled')
                                                        Geannuleerd
                                                    @else
                                                        {{ $invoice->status }}
                                                    @endif
                                                    ({{ $invoice->is_active ? 'Actief' : 'Inactief' }})
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="flex items-center justify-end mt-8 pt-4 border-t border-gray-200">
                                    <a href="{{ route('invoices.index') }}" 
                                        class="mr-3 px-5 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition duration-150 ease-in-out">
                                        Annuleren
                                    </a>
                                    <button type="submit" 
                                        class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        Factuur bijwerken
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>