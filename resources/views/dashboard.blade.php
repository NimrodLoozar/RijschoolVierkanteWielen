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
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg p-6">
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

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg p-6">
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

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg p-6">
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

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg p-6">
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

                <!-- Recent Activities Section (Moved here) -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg mb-8">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                            </svg>
                            Recente Activiteiten
                        </h3>
                    </div>
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="space-y-4">
                            @php
                                $recentLessons = \App\Models\Lessons::with('student', 'instructor')
                                    ->orderBy('created_at', 'desc')
                                    ->limit(5)
                                    ->get();
                                
                                $recentUsers = \App\Models\User::where('created_at', '>=', now()->subDays(7))
                                    ->orderBy('created_at', 'desc')
                                    ->limit(5)
                                    ->get();
                                    
                                $recentInvoices = \App\Models\Invoice::orderBy('created_at', 'desc')
                                    ->limit(3)
                                    ->get();
                            @endphp
                            
                            @forelse($recentLessons as $lesson)
                            <div class="flex items-start p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="p-2 bg-green-100 dark:bg-green-900 rounded-full mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-green-500 dark:text-green-300" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium">Nieuwe les ingepland</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        @if(isset($lesson->student) && isset($lesson->student->user))
                                            {{ $lesson->student->user->name }}
                                        @elseif(isset($lesson->student))
                                            Student #{{ $lesson->student->id }}
                                        @else
                                            Onbekende Student
                                        @endif
                                        - {{ $lesson->start_time }} - {{ $lesson->end_time }}
                                    </p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">{{ $lesson->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @empty
                            <div class="flex items-start p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="p-2 bg-gray-100 dark:bg-gray-900 rounded-full mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-gray-500 dark:text-gray-300" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium">Geen recente lessen</p>
                                </div>
                            </div>
                            @endforelse

                            @forelse($recentUsers as $user)
                            <div class="flex items-start p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-full mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-blue-500 dark:text-blue-300" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium">Nieuwe gebruiker geregistreerd</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @empty
                            <div class="flex items-start p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="p-2 bg-gray-100 dark:bg-gray-900 rounded-full mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-gray-500 dark:text-gray-300" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium">Geen nieuwe gebruikers</p>
                                </div>
                            </div>
                            @endforelse
                            
                            @forelse($recentInvoices as $invoice)
                            <div class="flex items-start p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="p-2 bg-yellow-100 dark:bg-yellow-900 rounded-full mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-yellow-500 dark:text-yellow-300" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium">Nieuwe factuur aangemaakt</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        #{{ $invoice->id }} - €{{ number_format($invoice->amount, 2, ',', '.') }} - {{ $invoice->status }}
                                    </p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">{{ $invoice->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @empty
                            <!-- No invoice notification is only shown if both lessons and users are also empty -->
                            @if($recentLessons->isEmpty() && $recentUsers->isEmpty())
                            <div class="flex items-start p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="p-2 bg-gray-100 dark:bg-gray-900 rounded-full mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-gray-500 dark:text-gray-300" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium">Geen recente activiteiten</p>
                                </div>
                            </div>
                            @endif
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Quick Actions Panel -->
                    <div
                        class="w-full lg:w-1/3 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg mb-8 lg:mb-0">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Snelle Acties
                            </h3>
                        </div>

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

                        <div
                            class="p-6 text-gray-900 dark:text-gray-100 border-t border-gray-200 dark:border-gray-700">
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

                    <!-- Activity Overview (Modified) -->
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
                </div>

                <!-- Bottom Section -->
                <div class="mt-8 flex flex-col lg:flex-row gap-8">
                    <!-- System Overview -->
                    <div class="w-full lg:w-2/3 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    Systeem Status
                                </h3>
                            </div>
                        </div>
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <h4 class="text-base font-medium mb-2">Schijfruimte</h4>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 mb-4">
                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: 35%"></div>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">3.5 GB van 10 GB gebruikt</p>
                                </div>
                                <div>
                                    <h4 class="text-base font-medium mb-2">CPU Gebruik</h4>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 mb-4">
                                        <div class="bg-green-600 h-2.5 rounded-full" style="width: 25%"></div>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">25% belasting</p>
                                </div>
                                <div>
                                    <h4 class="text-base font-medium mb-2">Geheugen</h4>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 mb-4">
                                        <div class="bg-yellow-600 h-2.5 rounded-full" style="width: 60%"></div>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">1.8 GB van 3 GB gebruikt</p>
                                </div>
                                <div>
                                    <h4 class="text-base font-medium mb-2">Database Grootte</h4>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 mb-4">
                                        <div class="bg-purple-600 h-2.5 rounded-full" style="width: 45%"></div>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">450 MB van 1 GB gebruikt</p>
                                </div>
                            </div>
                        </div>
                    </div>

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
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <p class="text-gray-900 dark:text-gray-100">Je hebt geen toegang tot dit dashboard.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Initialize chart when page loads
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
        
        // Custom toggle styling for maintenance mode
        document.getElementById('maintenance-toggle').addEventListener('change', function() {
            const dot = this.parentNode.querySelector('.dot');
            if (this.checked) {
                dot.classList.add('transform', 'translate-x-full', 'bg-red-500');
            } else {
                dot.classList.remove('transform', 'translate-x-full', 'bg-red-500');
            }
        });
    </script>
</x-app-layout>
