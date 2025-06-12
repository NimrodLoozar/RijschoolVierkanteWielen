<!-- System Controls -->
<div class="w-full lg:w-1/3 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Systeem Controle
            </h3>
        </div>
    </div>
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <div class="space-y-4">
            <!-- Maintenance Mode Toggle -->
            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-xl">
                <form method="POST" action="{{ route('toggle.maintenance') }}"
                    class="space-y-4">
                    @csrf
                    <div class="flex items-center justify-between">
                        <label for="maintenance-toggle" class="flex items-center cursor-pointer">
                            <span class="mr-3 text-sm font-medium">Onderhoudsmodus</span>
                            <div class="relative">
                                <input type="checkbox" id="maintenance-toggle"
                                    name="maintenance_mode" value="1" class="sr-only"
                                    {{ $isMaintenanceMode ? 'checked' : '' }}>
                                <div
                                    class="w-10 h-5 bg-gray-300 dark:bg-gray-600 rounded-full shadow-inner">
                                </div>
                                <div
                                    class="dot absolute w-5 h-5 bg-white rounded-full shadow -left-1 -top-0 transition {{ $isMaintenanceMode ? 'transform translate-x-full bg-red-500' : '' }}">
                                </div>
                            </div>
                        </label>
                        <span
                            class="px-2 py-1 text-xs {{ $isMaintenanceMode ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }} rounded-full">
                            {{ $isMaintenanceMode ? 'Actief' : 'Inactief' }}
                        </span>
                    </div>
                    <button type="submit"
                        class="w-full px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition duration-150 flex items-center justify-center shadow-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        Opslaan
                    </button>
                </form>
            </div>

            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-xl">
                <h4 class="text-base font-medium mb-2">Cache Beheer</h4>
                <button
                    class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-150 flex items-center justify-center shadow-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Cache Wissen
                </button>
            </div>
        </div>
    </div>
</div>

@once
    @push('scripts')
    <script>
        // Custom toggle styling for maintenance mode
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('maintenance-toggle')?.addEventListener('change', function() {
                const dot = this.parentNode.querySelector('.dot');
                if (this.checked) {
                    dot.classList.add('transform', 'translate-x-full', 'bg-red-500');
                } else {
                    dot.classList.remove('transform', 'translate-x-full', 'bg-red-500');
                }
            });
        });
    </script>
    @endpush
@endonce
