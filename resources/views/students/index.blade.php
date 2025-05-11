<x-app-layout>
    <x-slot name="header">
        <div class="mb-4 flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Students') }}
                </h2>
                <label class="flex items-center">
                    <span class="mr-2 text-gray-900 dark:text-gray-200">Toon Data</span>
                    <div
                        class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                        <input type="checkbox" id="dataToggle"
                            class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer transition-transform duration-200 ease-in-out"
                            checked />
                        <label for="dataToggle"
                            class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer transition-colors duration-200 ease-in-out"></label>
                    </div>
                </label>
            </div>

            <a href="{{ route('students.create') }}"
                class="bg-green-600 text-white px-5 py-2.5 rounded-lg transition duration-300 hover:bg-green-700 transform hover:scale-105">
                {{ __('Leerling toevoegen') }}
            </a>
        </div>
        {{-- I need this fore in the future --}}
        {{-- <a href="{{ route('students.import') }}"
            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-600 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 disabled:opacity-25 transition ease-in-out duration-150">
            {{ __('Import Students') }}
        </a>
        <a href="{{ route('students.export') }}"
            class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-500 active:bg-yellow-600 focus:outline-none focus:border-yellow-700 focus:ring focus:ring-yellow-200 disabled:opacity-25 transition ease-in-out duration-150">
            {{ __('Export Students') }}
        </a>
        <a href="{{ route('students.exportAll') }}"
            class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-500 active:bg-purple-600 focus:outline-none focus:border-purple-700 focus:ring focus:ring-purple-200 disabled:opacity-25 transition ease-in-out duration-150">
            {{ __('Export All Students') }}
        </a>
        <a href="{{ route('students.exportAllWithRoles') }}"
            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-600 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 disabled:opacity-25 transition ease-in-out duration-150">
            {{ __('Export All Students with Roles') }}
        </a> --}}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (count($students) > 0)
                <div id="dataContainer" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <table class="w-full min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Role
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @foreach ($students as $student)
                                    <tr>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-500">
                                            {{ $student->first_name ?? 'N/A' }}
                                            {{ $student->middle_name ?? '' }}
                                            {{ $student->last_name ?? 'N/A' }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $student->email ?? 'N/A' }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $student->role_name ?? 'No Role Assigned' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('students.edit', ['student' => $student->id]) }}"
                                                class="text-indigo-600 hover:text-indigo-900">Bijwerken</a>
                                            |
                                            <button type="button" class="text-red-600 hover:text-red-900"
                                                onclick="showDeleteModal({{ $student->id }})">
                                                Verwijderen
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div id="noStudentsError"
                    class="w-full bg-red-600 px-4 py-4 rounded relative dark:bg-red-800 dark:border-red-400"
                    role="alert">
                    {{-- <strong class="font-bold">Error!</strong> --}}
                    <span class="block sm:inline text-red-500 dark:text-gray-100">Geen leerlingen gevonden. Probeer
                        later
                        opnieuw of voeg leerlingen
                        toe.</span>
                </div>
            @endif
            <div id="errorContainer"
                class="w-full hidden bg-red-600 px-4 py-4 rounded relative dark:bg-red-800 dark:border-red-400">
                <p class="text-red-500 dark:text-gray-100">Geen leerlingen gevonden. Probeer later
                    opnieuw of voeg leerlingen
                    toe.</p>
            </div>
        </div>
    </div>

    {{-- Delete pop-up --}}
    <div class="relative z-10 hidden" id="delete-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div
                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
                                <svg class="size-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-base font-semibold text-gray-900" id="modal-title">Verwijder Instructeur
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Weet u zeker dat u deze instructeur wilt
                                        verwijderen?
                                        Deze actie kan niet ongedaan worden gemaakt.</p>
                                </div>
                                <div class="mt-4">
                                    <label for="delete-comment"
                                        class="block text-sm font-medium text-gray-700">Opmerking
                                        (verplicht)</label>
                                    <textarea id="delete-comment" name="delete_comment" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        placeholder="Voeg een opmerking toe van minimaal 5 tekens..." required></textarea>
                                    <p id="comment-error" class="text-red-600 text-sm hidden mt-2">De opmerking moet
                                        minimaal 5 tekens bevatten.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <form method="POST" id="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" id="confirm-delete"
                                class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 sm:ml-3 sm:w-auto">
                                Verwijderen
                            </button>
                        </form>
                        <button type="button" id="cancel-delete"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs ring-1 ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto">
                            Annuleren
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('dataToggle').addEventListener('change', function() {
            const dataContainer = document.getElementById('dataContainer');
            const errorContainer = document.getElementById('errorContainer');
            if (this.checked) {
                dataContainer.classList.remove('hidden');
                errorContainer.classList.add('hidden');
            } else {
                dataContainer.classList.add('hidden');
                errorContainer.classList.remove('hidden');
            }
        });

        function showDeleteModal(studentId) {
            const deleteForm = document.getElementById('delete-form');
            deleteForm.action = `/students/${studentId}`;
            document.getElementById('delete-modal').classList.remove('hidden');
        }

        document.getElementById('cancel-delete').addEventListener('click', function() {
            document.getElementById('delete-modal').classList.add('hidden');
        });

        document.getElementById('confirm-delete').addEventListener('click', function(event) {
            const comment = document.getElementById('delete-comment').value.trim();
            const errorElement = document.getElementById('comment-error');
            if (comment.length < 5) {
                event.preventDefault();
                errorElement.classList.remove('hidden');
            } else {
                errorElement.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
