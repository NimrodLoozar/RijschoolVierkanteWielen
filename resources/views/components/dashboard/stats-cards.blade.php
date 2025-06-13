<!-- Quick Stats Cards -->
<div class="mb-8">
    <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-t-lg shadow-xl cursor-pointer collapsible-header" data-target="stats-cards-content">
        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            Statistieken Overzicht
        </h3>
        <svg class="h-5 w-5 transform transition-transform duration-200 collapsible-arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>
    
    <div id="stats-cards-content" class="collapsible-content">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 p-4 bg-white dark:bg-gray-800 shadow-xl rounded-b-lg">
            <!-- Stat Card 1 -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-indigo-100 dark:bg-indigo-900 mr-4 shadow-xl">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 text-indigo-500 dark:text-indigo-300" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Totaal Accounts</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ \App\Models\User::count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Stat Card 2 -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 mr-4 shadow-xl">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 text-green-500 dark:text-green-300" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Actieve Lessen</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ \App\Models\Lessons::where('start_date', '>=', now()->format('Y-m-d'))->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Stat Card 3 -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900 mr-4 shadow-xl">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 text-yellow-500 dark:text-yellow-300" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Openstaande Facturen</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ \App\Models\Invoice::where('status', 'open')->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Stat Card 4 -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 mr-4 shadow-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 dark:text-blue-300"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Nieuwe Inschrijvingen</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ \App\Models\User::where('created_at', '>=', now()->subDays(7))->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
