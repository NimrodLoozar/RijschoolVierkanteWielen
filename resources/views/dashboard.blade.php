<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="bg-red-500 text-white p-4 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Gebruikersgegevens -->
                <div
                    class="w-full lg:w-1/3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8 lg:mb-0">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-2xl font-bold mb-4">Mijn Gegevens</h3>


                        <h4 class="text-xl font-semibold">Naam</h4>
                        <br>
                        <p>{{ Auth::user()->name }}</p>

                        
                    </div>

                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-2xl font-bold mb-4">Facturen</h3>
                        <a href="{{ route('invoices.index') }}" class="text-blue-500 hover:underline">
                            Bekijk facturen
                        </a>
                    </div>

                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-2xl font-bold mb-4">Accounts</h3>
                        <a href="{{ route('accounts.index') }}" class="text-blue-500 hover:underline">
                            Bekijk accounts
                        </a>
                    </div>
                </div>

                <!-- Boekinggegevens -->
                <div class="w-full lg:w-2/3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8 lg:mb-0">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-2xl font-bold">Placeholder per/</h3>
                        </div>
                        <button onclick="toggleBookings()" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 mb-4">
                                Toon Placeholder
                        </button>
                        <br>
                        <hr>
                        <br>
                        <div id="bookingStats" class="hidden">
                            <h4 class="text-2xl font-bold mb-4">Placeholder 1</h4>
                            <div class="mb-4">
                               
                            </div>

                            <h4 class="text-2xl font-bold mb-4">Placeholder 2</h4>
                            <div>
                             
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Section -->
            <div class="mt-8 flex flex-col lg:flex-row gap-8">
                <!-- Omzet per maand -->
                <div class="w-full lg:w-2/3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-2xl font-bold">Placeholder l</h3>
                        </div>
                        <div>
                           
                        </div>
                    </div>
                </div>

                <!-- populairste bestemmingen -->
                <div class="w-full lg:w-1/3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-2xl font-bold">Placeholder s</h3>
                        </div>
                        <div class="space-y-4">
                           
                        </div>
                    </div>
                </div>
            </div>

            <!-- Maintenance Mode Toggle -->
            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('toggle.maintenance') }}">
                    @csrf
                    <label for="maintenance-toggle" class="flex items-center">
                        <input type="checkbox" id="maintenance-toggle" name="maintenance_mode" value="1"
                            class="mr-2" {{ $isMaintenanceMode ? 'checked' : '' }}>
                        <span class="text-gray-900 dark:text-gray-100">Maintenance Mode</span>
                    </label>
                    <button type="submit"
                        class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Save
                    </button>
                </form>
            </div>
        </div>
    </div>

     <!-- Add Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function toggleBookings() {
            const stats = document.getElementById('bookingStats');
            const button = event.target;
            if (stats.classList.contains('hidden')) {
                stats.classList.remove('hidden');
                button.textContent = 'Verberg boekingen';
            } else {
                stats.classList.add('hidden');
                button.textContent = 'Toon boekingen';
            }
        }

        // Revenue Chart
        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const revenueData = @json($bookingStats['monthlyRevenue']);
        
        const labels = Object.keys(revenueData).map(month => monthNames[month - 1]);
        const values = Object.values(revenueData);

        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Maandelijkse Omzet (€)',
                    data: values,
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '€' + value.toLocaleString();
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return '€' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
