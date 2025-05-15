<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Instructeur Aanmaken') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <form method="POST" action="{{ route('instructors.store') }}">
                    @csrf
                    @if ($errors->any())
                        <div class="mb-4">
                            <ul class="mt-2 text-sm text-gray-300 bg-red-600 p-2 rounded-bl-xl rounded-tr-xl">
                                <li>{{ __('Er zijn fouten opgetreden:') }}</li>
                                @foreach ($errors->all() as $error)
                                    <li>- {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="mb-4">
                        <label for="first_name"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Voornaam*</label>
                        <input type="text" name="first_name" id="first_name"
                            class="bg-gray-200 text-gray-900 p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="Voornaam">
                    </div>
                    <div class="mb-4">
                        <label for="middle_name"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tussenvoegsel</label>
                        <input type="text" name="middle_name" id="middle_name"
                            class="bg-gray-200 text-gray-900 p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="Tussenvoegsel">
                    </div>
                    <div class="mb-4">
                        <label for="last_name"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Achternaam*</label>
                        <input type="text" name="last_name" id="last_name"
                            class="bg-gray-200 text-gray-900 p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="Achternaam">
                    </div>
                    <div class="mb-4">
                        <label for="username"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gebruikersnaam*</label>
                        <input type="text" name="username" id="username"
                            class="bg-gray-200 text-gray-900 p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="Gebruikersnaam">
                    </div>
                    <div class="mb-4">
                        <label for="email"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">E-mail*</label>
                        <input type="email" name="email" id="email"
                            class="bg-gray-200 text-gray-900 p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="Email">
                    </div>
                    <div class="mb-4">
                        <label for="birth_date"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Geboortedatum*</label>
                        <input type="date" name="birth_date" id="birth_date"
                            class="bg-gray-200 text-gray-900 p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="street"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Straat*</label>
                        <input type="text" name="street" id="street"
                            class="bg-gray-200 text-gray-900 p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="Straat">
                    </div>
                    <div class="mb-4">
                        <label for="house_number"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Huisnummer*</label>
                        <input type="text" name="house_number" id="house_number"
                            class="bg-gray-200 text-gray-900 p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="Huisnummer">
                    </div>
                    <div class="mb-4">
                        <label for="postal_code"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Postcode*</label>
                        <input type="text" name="postal_code" id="postal_code"
                            class="bg-gray-200 text-gray-900 p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="Postcode">
                    </div>
                    <div class="mb-4">
                        <label for="city"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stad*</label>
                        <input type="text" name="city" id="city"
                            class="bg-gray-200 text-gray-900 p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="Stad">
                    </div>
                    <div class="mb-4">
                        <label for="password"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Wachtwoord*</label>
                        <input type="password" name="password" id="password"
                            class="bg-gray-200 text-gray-900 p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="Wachtwoord">
                    </div>
                    <div class="mb-4">
                        <label for="password_confirmation"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bevestig
                            Wachtwoord*</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="bg-gray-200 text-gray-900 p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="Bevestig Wachtwoord">
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
