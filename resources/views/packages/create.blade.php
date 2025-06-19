<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lespakket toevoegen') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 mt-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <form method="POST" action="{{ route('packages.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type*</label>
                        <input type="text" name="type" id="type"
                            class="bg-gray-200 text-gray-900 p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="Type pakket" required pattern="^[\pL\s]+$" inputmode="text" autocomplete="off">
                        @error('type')
                            <div class="text-red-600 mt-1 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="lesson_count" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Aantal lessen*</label>
                        <input type="number" name="lesson_count" id="lesson_count"
                            class="bg-gray-200 text-gray-900 p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="Aantal lessen" min="0" max="100" required>
                    </div>
                    <div class="mb-4">
                        <label for="price_per_lesson" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Prijs per les*</label>
                        <input type="number" step="0.01" name="price_per_lesson" id="price_per_lesson"
                            class="bg-gray-200 text-gray-900 p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="Prijs per les" min="0" required>
                    </div>
                    <div class="mb-4">
                        <label for="is_active" class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" checked
                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-600">Actief</span>
                        </label>
                    </div>
                    <div class="mb-4">
                        <label for="note" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Opmerking</label>
                        <textarea name="note" id="note" rows="2"
                            class="bg-gray-200 text-gray-900 p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="Opmerking" pattern="^[\pL\s]*$" inputmode="text" autocomplete="off"></textarea>
                        @error('note')
                            <div class="text-red-600 mt-1 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Toevoegen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
