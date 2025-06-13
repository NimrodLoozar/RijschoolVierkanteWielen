<!-- Financial Overview -->
<div class="w-full lg:w-2/3 mb-8 lg:mb-0">
    <div class="flex items-center justify-between p-6 bg-white dark:bg-gray-800 rounded-t-lg shadow-xl border-b border-gray-200 dark:border-gray-700 cursor-pointer collapsible-header" data-target="financial-stats-content">
        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Financiële Statistieken
        </h3>
        <svg class="h-5 w-5 transform transition-transform duration-200 collapsible-arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>
    
    <div id="financial-stats-content" class="collapsible-content bg-white dark:bg-gray-800 shadow-xl rounded-b-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="mb-4 flex justify-between items-center">
                <h4 class="text-lg font-semibold">Maandelijkse Inkomsten</h4>
                <div class="flex space-x-2">
                    <button id="showBarChart" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Staafdiagram</button>
                    <button id="showLineChart" class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 text-sm">Lijndiagram</button>
                </div>
            </div>
            <div class="mb-6">
                <div id="chartLoadingIndicator" class="flex items-center justify-center p-6 text-blue-500">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Gegevens laden...
                </div>
                <div id="chartErrorContainer" class="hidden bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert"></div>
                <canvas id="monthlyStatsChart" height="200" class="hidden"></canvas>
            </div>
            
            <div class="mt-8">
                <h4 class="text-lg font-semibold mb-3">Inkomsten Overzicht</h4>
                <div class="overflow-x-auto">
                    <div id="tableLoadingIndicator" class="flex items-center justify-center p-6 text-blue-500">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Tabel laden...
                    </div>
                    <div id="tableErrorContainer" class="hidden bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert"></div>
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 hidden" id="financialDataTable">
                        <thead>
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Maand</th>
                                <th class="px-3 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Incl. BTW</th>
                                <th class="px-3 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Excl. BTW</th>
                                <th class="px-3 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">BTW</th>
                            </tr>
                        </thead>
                        <tbody id="monthlyDataTable" class="divide-y divide-gray-200 dark:divide-gray-700">
                            <!-- Table data will be populated by JavaScript -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-700 dark:text-gray-200 uppercase tracking-wider">Totaal</th>
                                <th id="totalInclVat" class="px-3 py-2 text-right text-xs font-medium text-gray-700 dark:text-gray-200 uppercase tracking-wider"></th>
                                <th id="totalExclVat" class="px-3 py-2 text-right text-xs font-medium text-gray-700 dark:text-gray-200 uppercase tracking-wider"></th>
                                <th id="totalVat" class="px-3 py-2 text-right text-xs font-medium text-gray-700 dark:text-gray-200 uppercase tracking-wider"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            
            <div class="mt-6 text-xs text-gray-500 dark:text-gray-400">
                <p id="lastUpdated">Laatst bijgewerkt: {{ now()->format('d-m-Y H:i:s') }}</p>
                <p id="dataStatus"></p>
            </div>
        </div>
    </div>
</div>

@once
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Financial statistics component loaded');
            
            // Check if Chart.js is loaded
            if (typeof Chart === 'undefined') {
                console.error('Chart.js is not loaded!');
                document.getElementById('chartErrorContainer').textContent = 'Error: Chart.js library not found. Please check your internet connection and refresh.';
                document.getElementById('chartErrorContainer').classList.remove('hidden');
                document.getElementById('chartLoadingIndicator').classList.add('hidden');
                document.getElementById('tableErrorContainer').textContent = 'Error: Required libraries not loaded.';
                document.getElementById('tableErrorContainer').classList.remove('hidden');
                document.getElementById('tableLoadingIndicator').classList.add('hidden');
                return;
            }
            
            const chartElement = document.getElementById('monthlyStatsChart');
            const chartLoadingIndicator = document.getElementById('chartLoadingIndicator');
            const chartErrorContainer = document.getElementById('chartErrorContainer');
            const tableElement = document.getElementById('financialDataTable');
            const tableLoadingIndicator = document.getElementById('tableLoadingIndicator');
            const tableErrorContainer = document.getElementById('tableErrorContainer');
            const dataStatusElement = document.getElementById('dataStatus');
            
            // Create fallback data in case PHP processing fails
            const fallbackMonthLabels = ['Jan', 'Feb', 'Mrt', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec'];
            const fallbackData = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            
            try {
                // Direct PHP data retrieval (for debugging)
                @php
                    try {
                        $currentYear = now()->year;
                        $monthlyData = [];
                        $monthlyDataExclVat = [];
                        $monthlyVat = [];
                        $monthNames = ['Jan', 'Feb', 'Mrt', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec'];
                        $errorMessage = null;
                        $debugInfo = [];
                        
                        // Check if Invoice model exists and is accessible
                        if (!class_exists('\\App\\Models\\Invoice')) {
                            throw new Exception('Invoice model niet gevonden');
                        }
                        
                        // Debug: Check table existence
                        try {
                            $tableExists = \Illuminate\Support\Facades\Schema::hasTable('invoices');
                            $debugInfo[] = "Invoices table exists: " . ($tableExists ? 'Yes' : 'No');
                            
                            if (!$tableExists) {
                                throw new Exception('Invoices table does not exist');
                            }
                            
                            // Get a count of invoices
                            $invoiceCount = \App\Models\Invoice::count();
                            $debugInfo[] = "Total invoice count: " . $invoiceCount;
                            
                            // Get a sample invoice to verify data structure
                            if ($invoiceCount > 0) {
                                $sampleInvoice = \App\Models\Invoice::first();
                                $debugInfo[] = "Sample invoice: ID=" . $sampleInvoice->id . 
                                    ", Number=" . $sampleInvoice->invoice_number . 
                                    ", Date=" . $sampleInvoice->invoice_date . 
                                    ", Amount=" . $sampleInvoice->amount_incl_vat;
                            } else {
                                $debugInfo[] = "No invoices found in database";
                            }
                            
                        } catch (\Exception $e) {
                            $debugInfo[] = "Error checking table: " . $e->getMessage();
                        }
                        
                        // Initialize with zeros
                        for ($i = 0; $i < 12; $i++) {
                            $monthlyData[$i] = 0;
                            $monthlyDataExclVat[$i] = 0;
                            $monthlyVat[$i] = 0;
                        }
                        
                        // Only attempt to query if table exists
                        if (isset($tableExists) && $tableExists) {
                            for ($month = 1; $month <= 12; $month++) {
                                $startDate = \Carbon\Carbon::create($currentYear, $month, 1);
                                $endDate = $startDate->copy()->endOfMonth();
                                
                                try {
                                    // Get monthly data with detailed query logging
                                    $monthlyQuery = \App\Models\Invoice::whereBetween('invoice_date', [$startDate, $endDate]);
                                    $monthAmount = $monthlyQuery->sum('amount_incl_vat');
                                    $monthExclVat = \App\Models\Invoice::whereBetween('invoice_date', [$startDate, $endDate])
                                        ->sum('amount_excl_vat');
                                    $monthVat = \App\Models\Invoice::whereBetween('invoice_date', [$startDate, $endDate])
                                        ->sum('vat');
                                    
                                    $monthlyData[$month-1] = floatval($monthAmount);
                                    $monthlyDataExclVat[$month-1] = floatval($monthExclVat);
                                    $monthlyVat[$month-1] = floatval($monthVat);
                                    
                                    // Debug info per month
                                    $recordCount = \App\Models\Invoice::whereBetween('invoice_date', [$startDate, $endDate])->count();
                                    if ($recordCount > 0) {
                                        $debugInfo[] = "Month {$month}: {$recordCount} invoices, total: {$monthAmount}";
                                    }
                                } catch (\Exception $e) {
                                    $debugInfo[] = "Error month {$month}: " . $e->getMessage();
                                }
                            }
                        }
                    } catch (\Exception $e) {
                        $errorMessage = $e->getMessage();
                        $debugInfo[] = "Main error: " . $e->getMessage();
                    }
                @endphp
                
                console.log('PHP script executed');
                
                const errorMessage = {!! json_encode(isset($errorMessage) ? $errorMessage : null) !!};
                const debugInfo = {!! json_encode(isset($debugInfo) ? $debugInfo : []) !!};
                
                console.log('Debug info:', debugInfo);
                
                if (errorMessage) {
                    console.error('PHP Error:', errorMessage);
                    throw new Error(errorMessage);
                }
                
                // Get data with fallback
                let chartData;
                let chartDataExclVat;
                let chartDataVat;
                let monthLabels;
                
                try {
                    chartData = {!! json_encode($monthlyData ?? []) !!};
                    chartDataExclVat = {!! json_encode($monthlyDataExclVat ?? []) !!};
                    chartDataVat = {!! json_encode($monthlyVat ?? []) !!};
                    monthLabels = {!! json_encode($monthNames ?? []) !!};
                    
                    console.log('Raw data received:', {
                        chartData,
                        chartDataExclVat, 
                        chartDataVat,
                        monthLabels
                    });
                    
                    // Validate data
                    if (!Array.isArray(chartData) || chartData.length === 0) {
                        throw new Error('No valid chart data received');
                    }
                } catch (e) {
                    console.error('Error parsing data from PHP:', e);
                    chartData = [...fallbackData];
                    chartDataExclVat = [...fallbackData];
                    chartDataVat = [...fallbackData];
                    monthLabels = [...fallbackMonthLabels];
                }
                
                console.log('Chart data prepared:', {
                    months: monthLabels,
                    inclVat: chartData,
                    exclVat: chartDataExclVat,
                    vat: chartDataVat
                });
                
                // Show data status with more details
                const totalAmount = chartData.reduce((sum, val) => sum + parseFloat(val || 0), 0);
                const monthsWithData = chartData.filter(val => parseFloat(val) > 0).length;
                dataStatusElement.textContent = `Gegevens: ${totalAmount.toFixed(2)} EUR totaal over ${monthsWithData} maanden met data.`;
                if (debugInfo && debugInfo.length > 0) {
                    dataStatusElement.title = debugInfo.join('\n');
                }
                
                // Format currency function
                function formatCurrency(value) {
                    return '€' + parseFloat(value).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')
                }
                
                let currentChart = null;
                
                // Create and render chart
                function createChart(type = 'bar') {
                    try {
                        if (currentChart) {
                            currentChart.destroy();
                        }
                        
                        const ctx = chartElement.getContext('2d');
                        if (!ctx) {
                            throw new Error('Could not get canvas context');
                        }
                        
                        console.log('Creating chart with type:', type);
                        
                        currentChart = new Chart(ctx, {
                            type: type,
                            data: {
                                labels: monthLabels,
                                datasets: [{
                                    label: 'Inkomsten incl. BTW',
                                    data: chartData,
                                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                                    borderColor: 'rgba(59, 130, 246, 1)',
                                    borderWidth: 2,
                                    tension: type === 'line' ? 0.3 : 0,
                                    fill: type === 'line'
                                },
                                {
                                    label: 'Inkomsten excl. BTW',
                                    data: chartDataExclVat,
                                    backgroundColor: 'rgba(16, 185, 129, 0.2)',
                                    borderColor: 'rgba(16, 185, 129, 1)',
                                    borderWidth: 2,
                                    tension: type === 'line' ? 0.3 : 0,
                                    fill: type === 'line'
                                },
                                {
                                    label: 'BTW',
                                    data: chartDataVat,
                                    backgroundColor: 'rgba(249, 115, 22, 0.2)',
                                    borderColor: 'rgba(249, 115, 22, 1)',
                                    borderWidth: 2,
                                    tension: type === 'line' ? 0.3 : 0,
                                    fill: type === 'line'
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            callback: function(value) {
                                                return formatCurrency(value);
                                            }
                                        }
                                    }
                                },
                                plugins: {
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                return context.dataset.label + ': ' + formatCurrency(context.raw);
                                            }
                                        }
                                    },
                                    legend: {
                                        position: 'bottom'
                                    }
                                }
                            }
                        });
                        console.log('Chart created successfully', type);
                    } catch (err) {
                        console.error('Error creating chart:', err);
                        chartErrorContainer.textContent = `Fout bij het maken van de grafiek: ${err.message}`;
                        chartErrorContainer.classList.remove('hidden');
                    }
                }
                
                // Populate data table
                function populateTable() {
                    try {
                        const tableBody = document.getElementById('monthlyDataTable');
                        if (!tableBody) {
                            throw new Error('Tabel element niet gevonden');
                        }
                        
                        tableBody.innerHTML = '';
                        let totalInclVat = 0;
                        let totalExclVat = 0;
                        let totalVat = 0;
                        
                        for (let i = 0; i < monthLabels.length; i++) {
                            const inclVat = parseFloat(chartData[i] || 0);
                            const exclVat = parseFloat(chartDataExclVat[i] || 0);
                            const vat = parseFloat(chartDataVat[i] || 0);
                            
                            totalInclVat += inclVat;
                            totalExclVat += exclVat;
                            totalVat += vat;
                            
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">${monthLabels[i]}</td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm text-right text-gray-900 dark:text-gray-100">${formatCurrency(inclVat)}</td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm text-right text-gray-900 dark:text-gray-100">${formatCurrency(exclVat)}</td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm text-right text-gray-900 dark:text-gray-100">${formatCurrency(vat)}</td>
                            `;
                            tableBody.appendChild(row);
                        }
                        
                        // Update totals
                        document.getElementById('totalInclVat').textContent = formatCurrency(totalInclVat);
                        document.getElementById('totalExclVat').textContent = formatCurrency(totalExclVat);
                        document.getElementById('totalVat').textContent = formatCurrency(totalVat);
                        
                        console.log('Table populated successfully', {
                            rows: monthLabels.length,
                            totalInclVat,
                            totalExclVat,
                            totalVat
                        });
                    } catch (err) {
                        console.error('Error populating table:', err);
                        tableErrorContainer.textContent = `Fout bij het vullen van de tabel: ${err.message}`;
                        tableErrorContainer.classList.remove('hidden');
                    }
                }
                
                // Initialize chart and table
                console.log('Attempting to initialize chart and table...');
                chartLoadingIndicator.classList.add('hidden');
                tableLoadingIndicator.classList.add('hidden');
                chartElement.classList.remove('hidden');
                tableElement.classList.remove('hidden');
                
                // Try creating chart immediately instead of with setTimeout
                try {
                    createChart('bar');
                    populateTable();
                    console.log('Chart and table initialized successfully');
                } catch (err) {
                    console.error('Error initializing chart and table:', err);
                    chartErrorContainer.textContent = `Er is een fout opgetreden bij initialisatie: ${err.message}`;
                    chartErrorContainer.classList.remove('hidden');
                }
                
                // Toggle chart type
                document.getElementById('showBarChart').addEventListener('click', function() {
                    this.classList.remove('bg-gray-200', 'text-gray-700');
                    this.classList.add('bg-blue-600', 'text-white');
                    document.getElementById('showLineChart').classList.remove('bg-blue-600', 'text-white');
                    document.getElementById('showLineChart').classList.add('bg-gray-200', 'text-gray-700');
                    createChart('bar');
                });
                
                document.getElementById('showLineChart').addEventListener('click', function() {
                    this.classList.remove('bg-gray-200', 'text-gray-700');
                    this.classList.add('bg-blue-600', 'text-white');
                    document.getElementById('showBarChart').classList.remove('bg-blue-600', 'text-white');
                    document.getElementById('showBarChart').classList.add('bg-gray-200', 'text-gray-700');
                    createChart('line');
                });
                
            } catch (err) {
                console.error('Main error:', err);
                chartLoadingIndicator.classList.add('hidden');
                tableLoadingIndicator.classList.add('hidden');
                chartErrorContainer.textContent = `Er is een fout opgetreden: ${err.message}`;
                tableErrorContainer.textContent = `Er is een fout opgetreden: ${err.message}`;
                chartErrorContainer.classList.remove('hidden');
                tableErrorContainer.classList.remove('hidden');
                
                // Display any debug info in the error container
                if (typeof debugInfo !== 'undefined' && debugInfo && debugInfo.length > 0) {
                    const debugDetails = document.createElement('details');
                    debugDetails.innerHTML = `<summary>Debug details</summary><pre>${debugInfo.join('\n')}</pre>`;
                    chartErrorContainer.appendChild(debugDetails);
                }
                
                // Add retry button
                const retryButton = document.createElement('button');
                retryButton.textContent = 'Probeer opnieuw';
                retryButton.className = 'mt-3 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700';
                retryButton.onclick = function() {
                    location.reload();
                };
                chartErrorContainer.appendChild(retryButton);
            }
        });
    </script>
    @endpush
@endonce
