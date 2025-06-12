<!-- Activity Overview -->
<div class="w-full lg:w-2/3 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg mb-8 lg:mb-0">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
            </svg>
            Activiteiten Statistieken
        </h3>
    </div>
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <h4 class="text-lg font-semibold mb-4">Dagelijkse Statistieken</h4>
        <div class="mb-6">
            <canvas id="dailyStatsChart" height="200"></canvas>
        </div>
    </div>
</div>

@once
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('dailyStatsChart').getContext('2d');
            
            // Get data from PHP
            @php
                $weekData = [
                    \App\Models\Lessons::whereDate('start_date', now()->startOfWeek()->addDays(0)->format('Y-m-d'))->count(),
                    \App\Models\Lessons::whereDate('start_date', now()->startOfWeek()->addDays(1)->format('Y-m-d'))->count(),
                    \App\Models\Lessons::whereDate('start_date', now()->startOfWeek()->addDays(2)->format('Y-m-d'))->count(),
                    \App\Models\Lessons::whereDate('start_date', now()->startOfWeek()->addDays(3)->format('Y-m-d'))->count(),
                    \App\Models\Lessons::whereDate('start_date', now()->startOfWeek()->addDays(4)->format('Y-m-d'))->count(),
                    \App\Models\Lessons::whereDate('start_date', now()->startOfWeek()->addDays(5)->format('Y-m-d'))->count(),
                    \App\Models\Lessons::whereDate('start_date', now()->startOfWeek()->addDays(6)->format('Y-m-d'))->count(),
                ];
            @endphp
            
            const chartData = {{ json_encode($weekData) }};
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag', 'Zondag'],
                    datasets: [{
                        label: 'Geboekte lessen',
                        data: chartData,
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 2,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
    @endpush
@endonce
