<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Nieuwe Factuur') }}
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
                            <h2 class="text-2xl font-semibold text-gray-800 mb-6 pb-2 border-b border-gray-200">Nieuwe factuur aanmaken</h2>

                            <form method="POST" action="{{ route('invoices.store') }}">
                                @csrf

                                <!-- Factuur informatie section -->
                                <div class="mb-8 bg-gray-50 p-5 rounded-lg shadow-sm">
                                    <h3 class="text-lg font-medium text-gray-800 mb-4 pb-2 border-b-2 border-gray-200">Factuur informatie</h3>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Factuur nummer -->
                                        <div class="mb-3">
                                            <label for="invoice_number" class="block text-sm font-medium text-gray-700 mb-1">Factuurnummer</label>
                                            <input type="text" name="invoice_number" id="invoice_number" 
                                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 bg-gray-100 @error('invoice_number') border-red-500 @enderror" 
                                                value="{{ old('invoice_number', $nextInvoiceNumber ?? 'AUTO') }}" readonly>
                                            <p class="text-xs text-gray-500 mt-1">Factuurnummer wordt automatisch gegenereerd</p>
                                            @error('invoice_number')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Factuurdatum -->
                                        <div class="mb-3">
                                            <label for="invoice_date" class="block text-sm font-medium text-gray-700 mb-1">Factuurdatum</label>
                                            <input type="date" name="invoice_date" id="invoice_date" 
                                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 @error('invoice_date') border-red-500 @enderror" 
                                                value="{{ old('invoice_date', date('Y-m-d')) }}" required>
                                            @error('invoice_date')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Registration selection -->
                                    <div class="mt-4">
                                        <label for="registration_id" class="block text-sm font-medium text-gray-700 mb-1">Registratie</label>
                                        <select name="registration_id" id="registration_id" 
                                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 @error('registration_id') border-red-500 @enderror" required>
                                            <option value="">-- Selecteer een registratie --</option>
                                            @foreach($registrations as $registration)
                                                <option value="{{ $registration->id }}" {{ old('registration_id') == $registration->id ? 'selected' : '' }}>
                                                    {{ $registration->description }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('registration_id')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
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
                                                    value="{{ old('amount_excl_vat', '0.00') }}" required>
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
                                                    value="{{ old('vat', '0.00') }}" required>
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
                                                    value="{{ old('amount_incl_vat', '0.00') }}" required>
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
                                                <option value="Onbetaald" {{ old('status') == 'Onbetaald' ? 'selected' : '' }}>Onbetaald</option>
                                                <option value="Betaald" {{ old('status') == 'Betaald' ? 'selected' : '' }}>Betaald</option>
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
                                                <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Actief</option>
                                                <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Inactief</option>
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
                                            placeholder="Voeg hier eventuele opmerkingen toe...">{{ old('note') }}</textarea>
                                        @error('note')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
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
                                        Factuur aanmaken
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const amountExclVat = document.getElementById('amount_excl_vat');
            const vatAmount = document.getElementById('vat');
            const amountInclVat = document.getElementById('amount_incl_vat');
            
            // VAT rate (21%)
            const vatRate = 0.21;
            
            // Function to format number to 2 decimal places
            function formatNumber(num) {
                return (Math.round(num * 100) / 100).toFixed(2);
            }
            
            // Function to calculate VAT and total amount
            function calculateAmounts(source) {
                // Prevent recursive calculations
                if (window.calculating) return;
                window.calculating = true;
                
                try {
                    // Parse values to numbers
                    const parseValue = (val) => parseFloat(val || 0);
                    
                    if (source === 'excl') {
                        // Calculate from amount excluding VAT
                        const baseAmount = parseValue(amountExclVat.value);
                        const calculatedVat = baseAmount * vatRate;
                        const total = baseAmount + calculatedVat;
                        
                        vatAmount.value = formatNumber(calculatedVat);
                        amountInclVat.value = formatNumber(total);
                    } 
                    else if (source === 'vat') {
                        // If VAT is manually changed, recalculate total
                        const baseAmount = parseValue(amountExclVat.value);
                        const manualVat = parseValue(vatAmount.value);
                        const total = baseAmount + manualVat;
                        
                        amountInclVat.value = formatNumber(total);
                    }
                    else if (source === 'incl') {
                        // Calculate from amount including VAT
                        const total = parseValue(amountInclVat.value);
                        const baseAmount = total / (1 + vatRate);
                        const calculatedVat = total - baseAmount;
                        
                        amountExclVat.value = formatNumber(baseAmount);
                        vatAmount.value = formatNumber(calculatedVat);
                    }
                } finally {
                    window.calculating = false;
                }
            }
            
            // Add event listeners to all amount fields
            amountExclVat.addEventListener('input', () => calculateAmounts('excl'));
            vatAmount.addEventListener('input', () => calculateAmounts('vat'));
            amountInclVat.addEventListener('input', () => calculateAmounts('incl'));
            
            // Initial calculation
            calculateAmounts('excl');
            
            // Make sure registration is selected before form submission
            document.querySelector('form').addEventListener('submit', function(e) {
                const registrationId = document.getElementById('registration_id').value;
                if (!registrationId) {
                    e.preventDefault();
                    alert('Selecteer een registratie voordat u de factuur aanmaakt.');
                }
            });
        });
    </script>
</x-app-layout>
