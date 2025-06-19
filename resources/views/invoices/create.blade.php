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

                                <!-- Developer Tools (Only visible in development) -->
                                <div class="mb-8 bg-yellow-50 p-5 rounded-lg shadow-sm border border-yellow-200">
                                    <h3 class="text-lg font-medium text-yellow-700 mb-4 pb-2 border-b-2 border-yellow-200 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                        </svg>
                                        Developer Tools
                                    </h3>
                                    
                                    <div class="mb-3">
                                        <input type="hidden" name="simulate_error" id="simulate_error_input" value="0">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" id="simulate_error_checkbox" class="hidden">
                                            <span class="relative inline-block w-10 h-5 rounded-full bg-gray-300 transition-colors ease-in-out duration-200 mr-3" id="simulate_error_toggle">
                                                <span class="simulate-error-slider absolute left-0.5 top-0.5 bg-white w-4 h-4 rounded-full transition-transform duration-200 transform"></span>
                                            </span>
                                            <span class="text-sm font-medium text-yellow-700">Simuleer technische fout</span>
                                        </label>
                                        <p class="text-xs text-yellow-600 mt-1">Alleen voor testdoeleinden. Hiermee kun je een fout simuleren tijdens het aanmaken van een factuur.</p>
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
            
            // Toggle functionality for simulate error
            const simulateErrorCheckbox = document.getElementById('simulate_error_checkbox');
            const simulateErrorInput = document.getElementById('simulate_error_input');
            const simulateErrorToggle = document.getElementById('simulate_error_toggle');
            
            if (simulateErrorCheckbox && simulateErrorInput && simulateErrorToggle) {
                simulateErrorCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        simulateErrorInput.value = '1';
                        simulateErrorToggle.classList.remove('bg-gray-300');
                        simulateErrorToggle.classList.add('bg-yellow-500');
                        document.querySelector('.simulate-error-slider').classList.add('translate-x-5');
                    } else {
                        simulateErrorInput.value = '0';
                        simulateErrorToggle.classList.remove('bg-yellow-500');
                        simulateErrorToggle.classList.add('bg-gray-300');
                        document.querySelector('.simulate-error-slider').classList.remove('translate-x-5');
                    }
                });
            }
        });
    </script>
</x-app-layout>
