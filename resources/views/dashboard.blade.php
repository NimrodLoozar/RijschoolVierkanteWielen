<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
            <span class="px-3 py-1 text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full">
                {{ now()->format('d M Y') }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="bg-red-500 text-white p-4 rounded mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (auth()->user() && auth()->user()->hasRole('Admin'))
                <!-- Quick Stats Cards -->
                <x-dashboard.stats-cards />

                <!-- Recent Activities Section -->
                <x-dashboard.recent-activities />

                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Quick Actions Panel -->
                    <x-dashboard.quick-actions />

                    <!-- Activity Overview -->
                    <x-dashboard.activity-statistics />
                </div>

                <!-- Bottom Section -->
                <div class="mt-8 flex flex-col lg:flex-row gap-8">
                    <!-- System Overview -->
                    <x-dashboard.system-overview />

                    <!-- System Controls -->
                    <x-dashboard.system-controls :isMaintenanceMode="$isMaintenanceMode" />
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <p class="text-gray-900 dark:text-gray-100">Je hebt geen toegang tot dit dashboard.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        // Verify Chart.js loaded
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Chart === 'undefined') {
                console.error('Chart.js failed to load!');
                alert('Error: Chart.js could not be loaded. Some dashboard features may not work.');
            } else {
                console.log('Chart.js loaded successfully');
            }
        });
    </script>
    
    @stack('scripts')
</x-app-layout>
