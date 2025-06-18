<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Nieuwe Betaling
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($errors->has('duplicate'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            {{ $errors->first('duplicate') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('betalingen.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="invoice_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Selecteer Factuur*
                            </label>
                            <select name="invoice_id" id="invoice_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600"
                                required>
                                <option value="">Kies een factuur</option>
                                @foreach($unpaidInvoices as $invoice)
                                    <option value="{{ $invoice->id }}" 
                                            data-number="{{ $invoice->invoice_number }}">
                                        {{ $invoice->invoice_number }} - €{{ number_format($invoice->amount_incl_vat, 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <input type="hidden" name="invoice_number" id="invoice_number">

                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Datum*
                            </label>
                            <input type="date" name="date" id="date"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600"
                                value="{{ old('date', date('Y-m-d')) }}" required>
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Status*
                            </label>
                            <select name="status" id="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600"
                                required>
                                <option value="">Selecteer een status</option>
                                <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Open</option>
                                <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Betaald</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Geannuleerd</option>
                            </select>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Omschrijving
                            </label>
                            <textarea name="description" id="description" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600"
                            >{{ old('description') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-6 space-x-3">
                            <a href="{{ route('betalingen.index') }}" 
                                class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition ease-in-out duration-150">
                                Annuleren
                            </a>
                            <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                                Opslaan
                            </button>
                        </div>
                    </form>

                    <script>
                    document.getElementById('invoice_id').addEventListener('change', function() {
                        const selectedOption = this.options[this.selectedIndex];
                        if (selectedOption.value) {
                            const invoiceNumber = selectedOption.dataset.number;
                            document.getElementById('invoice_number').value = invoiceNumber;
                        } else {
                            document.getElementById('invoice_number').value = '';
                        }
                    });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>