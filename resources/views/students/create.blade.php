<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Leerling Aanmaken') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <form method="POST" action="{{ route('students.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="first_name"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Voornaam</label>
                        <input type="text" name="first_name" id="first_name"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            required>
                    </div>
                    <div class="mb-4">
                        <label for="middle_name"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tussenvoegsel</label>
                        <input type="text" name="middle_name" id="middle_name"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="last_name"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Achternaam</label>
                        <input type="text" name="last_name" id="last_name"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            required>
                    </div>
                    <div class="mb-4">
                        <label for="email"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">E-mail</label>
                        <input type="email" name="email" id="email"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            required>
                    </div>
                    <div class="mb-4">
                        <label for="phone"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Telefoonnummer</label>
                        <input type="text" name="phone" id="phone"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Aanmaken
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
