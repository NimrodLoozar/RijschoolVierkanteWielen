<!-- Recent Activities Section -->
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
