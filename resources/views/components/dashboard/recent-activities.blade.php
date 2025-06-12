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
                // Collect recent activities from different models
                $recentUsers = \App\Models\User::orderBy('created_at', 'desc')->take(3)->get();
                $recentStudents = \App\Models\Student::with('user')->orderBy('created_at', 'desc')->take(3)->get();
                $recentInstructors = \App\Models\Instructor::with('user')->orderBy('created_at', 'desc')->take(3)->get();
                $recentAutos = \App\Models\Auto::orderBy('created_at', 'desc')->take(3)->get();
                $recentInvoices = \App\Models\Invoice::orderBy('created_at', 'desc')->take(3)->get();
                
                // Merge all activities and sort by creation date
                $activities = collect();
                
                foreach($recentUsers as $user) {
                    $activities->push([
                        'type' => 'user',
                        'title' => 'Nieuw account',
                        'description' => $user->first_name . ' ' . $user->last_name,
                        'created_at' => $user->created_at,
                        'icon' => 'user'
                    ]);
                }
                
                foreach($recentStudents as $student) {
                    $activities->push([
                        'type' => 'student',
                        'title' => 'Nieuwe student',
                        'description' => $student->user->first_name . ' ' . $student->user->last_name,
                        'created_at' => $student->created_at,
                        'icon' => 'academic-cap'
                    ]);
                }
                
                foreach($recentInstructors as $instructor) {
                    $activities->push([
                        'type' => 'instructor',
                        'title' => 'Nieuwe instructeur',
                        'description' => $instructor->user->first_name . ' ' . $instructor->user->last_name,
                        'created_at' => $instructor->created_at,
                        'icon' => 'briefcase'
                    ]);
                }
                
                foreach($recentAutos as $auto) {
                    $activities->push([
                        'type' => 'auto',
                        'title' => 'Nieuw voertuig',
                        'description' => $auto->brand . ' ' . $auto->model . ' (' . $auto->license_plate . ')',
                        'created_at' => $auto->created_at,
                        'icon' => 'truck'
                    ]);
                }
                
                foreach($recentInvoices as $invoice) {
                    $activities->push([
                        'type' => 'invoice',
                        'title' => 'Nieuwe factuur',
                        'description' => 'Factuurnr: ' . $invoice->invoice_number . ' - €' . number_format($invoice->amount_incl_vat, 2, ',', '.'),
                        'created_at' => $invoice->created_at,
                        'icon' => 'document-text'
                    ]);
                }
                
                $activities = $activities->sortByDesc('created_at')->take(10);
            @endphp
            
            @forelse($activities as $activity)
                <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg shadow">
                    <div class="mr-4">
                        @if($activity['icon'] === 'user')
                            <div class="p-2 rounded-full bg-blue-100 dark:bg-blue-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        @elseif($activity['icon'] === 'academic-cap')
                            <div class="p-2 rounded-full bg-green-100 dark:bg-green-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 dark:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                            </div>
                        @elseif($activity['icon'] === 'briefcase')
                            <div class="p-2 rounded-full bg-purple-100 dark:bg-purple-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500 dark:text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @elseif($activity['icon'] === 'truck')
                            <div class="p-2 rounded-full bg-yellow-100 dark:bg-yellow-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 dark:text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                            </div>
                        @elseif($activity['icon'] === 'document-text')
                            <div class="p-2 rounded-full bg-red-100 dark:bg-red-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 dark:text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-medium">{{ $activity['title'] }}</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $activity['description'] }}</p>
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $activity['created_at']->diffForHumans() }}
                    </div>
                </div>
            @empty
                <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg text-center">
                    <p class="text-gray-500 dark:text-gray-400">Geen recente activiteiten</p>
                </div>
            @endforelse
            
        </div>
    </div>
</div>
