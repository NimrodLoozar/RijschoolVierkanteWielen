<x-app-layout>
    <x-slot name="header">
        <div class="mb-4 flex justify-between items-center bg-white dark:bg-gray-800 shadow-md sm:rounded-lg p-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Instructeurs') }}
                </h2>
                <label class="flex items-center">
                    <span class="mr-2 text-gray-900 dark:text-gray-200">Toon Data</span>
                    <div
                        class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                        <input type="checkbox" id="dataToggle"
                            class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"
                            checked />
                        <label for="dataToggle"
                            class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                    </div>
                </label>
            </div>

            <a href="{{ route('instructors.create') }}"
                class="bg-green-600 text-white px-5 py-2.5 rounded-lg transition duration-300 hover:bg-green-700 transform hover:scale-105">
                {{ __('Instructeur toevoegen') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (count($instructors) > 0)
                <div id="dataContainer" class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 hidden md:block">
                        <table class="w-full min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Naam
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Rol
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @foreach ($instructors as $instructor)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-700 dark:text-blue-500">
                                            {{ $instructor->first_name ?? 'N/A' }}
                                            {{ $instructor->middle_name ?? '' }}
                                            {{ $instructor->last_name ?? 'N/A' }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $instructor->email ?? 'N/A' }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-100 dark:text-gray-200">
                                            <span
                                                class="bg-green-500 dark:bg-green-500/70 py-1 px-2 rounded-xl">{{ $instructor->role_name ?? 'No Role Assigned' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex flex-row space-x-2">
                                                {{-- <a href="{{ route('students.show', ['student' => $student->id]) }}"
                                                    class="text-blue-600 hover:text-blue-900" title="Bekijk">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.25 12s3.75-7.5 9.75-7.5 9.75 7.5 9.75 7.5-3.75 7.5-9.75 7.5S2.25 12 2.25 12z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                                    </svg>
                                                </a> --}}
                                                <a href="{{ route('instructors.edit', ['instructor' => $instructor->id]) }}"
                                                    class="text-indigo-600 hover:text-indigo-500" title="Bewerk">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        fill="currentColor" class="size-6">
                                                        <path
                                                            d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                                        <path
                                                            d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                                    </svg>
                                                </a>
                                                <button type="button" class="text-red-600 hover:text-red-500"
                                                    onclick="showDeleteModal({{ $instructor->id }})" title="Verwijder">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        fill="currentColor" class="size-6">
                                                        <path fill-rule="evenodd"
                                                            d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:hidden">
                    {{-- Mobile view --}}
                    @foreach ($instructors as $instructor)
                        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 flex flex-col space-y-2">
                            <div class="flex justify-between items-center">
                                <div class="flex space-2 items-center">
                                    <h3
                                        class="w-56 sm:max-w-32 sm:truncate text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $instructor->first_name ?? 'N/A' }}
                                        {{ $instructor->middle_name ?? '' }}
                                        {{ $instructor->last_name ?? 'N/A' }}
                                    </h3>
                                    <p class="text-sm text-gray-300 dark:text-gray-200 ml-2">
                                        <span
                                            class="bg-green-500/70 py-1 px-2 rounded-xl">{{ $instructor->role_name ?? 'No Role Assigned' }}
                                        </span>
                                    </p>
                                </div>
                                <div class="flex space-x-2 ml-2">
                                    <a href="{{ route('instructors.edit', ['instructor' => $instructor->id]) }}"
                                        class="text-indigo-600 hover:text-indigo-500" title="Bewerk">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="size-6">
                                            <path
                                                d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                            <path
                                                d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                        </svg>
                                    </a>
                                    <button type="button" class="text-red-600 hover:text-red-500"
                                        onclick="showDeleteModal({{ $instructor->id }})" title="Verwijder">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="size-6">
                                            <path fill-rule="evenodd"
                                                d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $instructor->email ?? 'N/A' }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <div id="noinstructorsError"
                    class="w-full bg-red-600 px-4 py-4 rounded relative dark:bg-red-800 dark:border-red-400 text-center shadow-2xl"
                    role="alert">
                    <span class="block sm:inline text-gray-100">Geen instructeurs gevonden. Probeer
                        later
                        opnieuw of voeg instructeurs
                        toe.</span>
                </div>
            @endif
            <div id="errorContainer"
                class="w-full hidden bg-red-600 px-4 py-4 rounded relative dark:bg-red-800 dark:border-red-400 text-center shadow-2xl">
                <p class="text-gray-100">Geen instructeurs gevonden. Probeer later
                    opnieuw of voeg instructeurs
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
                                <svg class="size-6 text-red-600" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-base font-semibold text-gray-900" id="modal-title">Verwijder
                                    Instructeur
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

        function showDeleteModal(instructorId) {
            const deleteForm = document.getElementById('delete-form');
            deleteForm.action = `/instructors/${instructorId}`;
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
