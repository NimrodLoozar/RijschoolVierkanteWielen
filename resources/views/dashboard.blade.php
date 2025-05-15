<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>

            <!-- Maintenance Mode Toggle -->
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
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
    </script>
</x-app-layout>
