<!-- Financial Overview -->
<div class="w-full lg:w-2/3 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg mb-8 lg:mb-0">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Financiële Statistieken
        </h3>
    </div>
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

@once
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Financial statistics component loaded');
            
            const chartElement = document.getElementById('monthlyStatsChart');
            const chartLoadingIndicator = document.getElementById('chartLoadingIndicator');
            const chartErrorContainer = document.getElementById('chartErrorContainer');
            const tableElement = document.getElementById('financialDataTable');
            const tableLoadingIndicator = document.getElementById('tableLoadingIndicator');
            const tableErrorContainer = document.getElementById('tableErrorContainer');
            const dataStatusElement = document.getElementById('dataStatus');
            
            try {
                // Get data from PHP
                @php
                    try {
                        $currentYear = now()->year;
                        $monthlyData = [];
                        $monthlyDataExclVat = [];
                        $monthlyVat = [];
                        $monthNames = ['Jan', 'Feb', 'Mrt', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec'];
                        $errorMessage = null;
                        
                        // Check if Invoice model exists
                        if (!class_exists('\\App\\Models\\Invoice')) {
                            throw new Exception('Invoice model niet gevonden');
                        }
                        
                        for ($month = 1; $month <= 12; $month++) {
                            $startDate = \Carbon\Carbon::create($currentYear, $month, 1);
                            $endDate = $startDate->copy()->endOfMonth();
                            
                            try {
                                $monthlyData[] = \App\Models\Invoice::whereBetween('invoice_date', [$startDate, $endDate])
                                    ->sum('amount_incl_vat');
                                    
                                $monthlyDataExclVat[] = \App\Models\Invoice::whereBetween('invoice_date', [$startDate, $endDate])
                                    ->sum('amount_excl_vat');
                                    
                                $monthlyVat[] = \App\Models\Invoice::whereBetween('invoice_date', [$startDate, $endDate])
                                    ->sum('vat');
                            } catch (\Exception $e) {
                                throw new Exception('Fout bij ophalen gegevens voor maand ' . $month . ': ' . $e->getMessage());
                            }
                        }
                    } catch (\Exception $e) {
                        $errorMessage = $e->getMessage();
                        $monthlyData = array_fill(0, 12, 0);
                        $monthlyDataExclVat = array_fill(0, 12, 0);
                        $monthlyVat = array_fill(0, 12, 0);
                    }
                @endphp
                
                const errorMessage = {!! json_encode(isset($errorMessage) ? $errorMessage : null) !!};
                
                if (errorMessage) {
                    console.error('PHP Error:', errorMessage);
                    throw new Error(errorMessage);
                }
                
                const chartData = {{ json_encode($monthlyData) }};
                const chartDataExclVat = {{ json_encode($monthlyDataExclVat) }};
                const chartDataVat = {{ json_encode($monthlyVat) }};
                const monthLabels = {{ json_encode($monthNames) }};
                
                console.log('Chart data loaded:', {
                    months: monthLabels,
                    inclVat: chartData,
                    exclVat: chartDataExclVat,
                    vat: chartDataVat
                });
                
                // Validate data
                if (!Array.isArray(chartData) || !Array.isArray(chartDataExclVat) || !Array.isArray(chartDataVat)) {
                    throw new Error('Ongeldige gegevensstructuur ontvangen');
                }
                
                // Show data status
                dataStatusElement.textContent = `Gegevens: ${chartData.reduce((sum, val) => sum + parseFloat(val || 0), 0).toFixed(2)} EUR totaal over ${chartData.filter(val => parseFloat(val) > 0).length} maanden met data.`;
                
                let currentChart;
                
                // Format currency function
                function formatCurrency(value) {
                    return '€' + parseFloat(value).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')
                }
                
                // Create and render chart
                function createChart(type = 'bar') {
                    try {
                        if (currentChart) {
                            currentChart.destroy();
                        }
                        
                        currentChart = new Chart(chartElement.getContext('2d'), {
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
                setTimeout(() => {
                    chartLoadingIndicator.classList.add('hidden');
                    tableLoadingIndicator.classList.add('hidden');
                    chartElement.classList.remove('hidden');
                    tableElement.classList.remove('hidden');
                    
                    createChart('bar');
                    populateTable();
                }, 500);
                
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
            }
        });
    </script>
    @endpush
@endonce
