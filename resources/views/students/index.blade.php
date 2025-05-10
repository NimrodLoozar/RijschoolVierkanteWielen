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
                                                class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            |
                                            <form action="{{ route('students.destroy', ['student' => $student->id]) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
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
</x-app-layout>

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
</script>
