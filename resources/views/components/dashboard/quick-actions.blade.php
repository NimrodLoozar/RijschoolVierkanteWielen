<!-- Quick Actions Panel -->
<div class="w-full lg:w-1/3 mb-8 lg:mb-0">
    <div class="flex items-center justify-between p-6 bg-white dark:bg-gray-800 rounded-t-lg shadow-xl border-b border-gray-200 dark:border-gray-700 cursor-pointer collapsible-header"
        data-target="quick-actions-content">
        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            Snelle Acties
        </h3>
        <svg class="h-5 w-5 transform transition-transform duration-200 collapsible-arrow" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>

    <div id="quick-actions-content"
        class="collapsible-content bg-white dark:bg-gray-800 shadow-xl rounded-b-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h4 class="text-lg font-semibold mb-3">Accounts Beheer</h4>
            <a href="{{ route('accounts.index') }}"
                class="flex items-center px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 mb-4 transition duration-150 shadow-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Bekijk accounts
            </a>
            <a href="{{ route('accounts.create') }}"
                class="flex items-center px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 mb-4 transition duration-150 shadow-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                Nieuw account
            </a>
        </div>

        <div class="p-6 text-gray-900 dark:text-gray-100 border-t border-gray-200 dark:border-gray-700">
            <h4 class="text-lg font-semibold mb-3">Financiën</h4>
            <a href="{{ route('invoices.index') }}"
                class="flex items-center px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 mb-4 transition duration-150 shadow-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            Bekijk facturen
            </a>
            <a href="{{ route('invoices.create') }}"
                class="flex items-center px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 mb-4 transition duration-150 shadow-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Nieuwe factuur
            </a>
        </div>
    </div>
</div>



