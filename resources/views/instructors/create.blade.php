<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Instructeur Aanmaken') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 mt-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <form method="POST" action="{{ route('instructors.store') }}">
                    @csrf

                    @if ($errors->has('username') || $errors->has('email'))
                        <div class="mb-4">
                            <ul class="mt-2 text-sm text-gray-300 bg-red-600 p-2 rounded-bl-xl rounded-tr-xl">
                                <li>{{ __('Er zijn fouten opgetreden:') }}</li>
                                @foreach ($errors->get('username') as $error)
                                    <li>- {{ $error }}</li>
                                @endforeach
                                @foreach ($errors->get('email') as $error)
                                    <li>- {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- NAAM --}}
                    <div class="mb-2">
                        <div class="text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Naam</div>
                        <div class="flex gap-2">
                            <div class="flex-1">
                                <label for="first_name"
                                    class="block text-xs font-medium text-gray-700 dark:text-gray-300">Voornaam*</label>
                                <input type="text" name="first_name" id="first_name"
                                    class="bg-gray-200 text-gray-900 p-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs"
                                    placeholder="Voornaam" value="{{ old('first_name') }}">
                                @error('first_name')
                                    <span class="text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-24">
                                <label for="middle_name"
                                    class="block text-xs font-medium text-gray-700 dark:text-gray-300">Tussenv.</label>
                                <input type="text" name="middle_name" id="middle_name"
                                    class="bg-gray-200 text-gray-900 p-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs"
                                    placeholder="Tussenv." value="{{ old('middle_name') }}">
                            </div>
                            <div class="flex-1">
                                <label for="last_name"
                                    class="block text-xs font-medium text-gray-700 dark:text-gray-300">Achternaam*</label>
                                <input type="text" name="last_name" id="last_name"
                                    class="bg-gray-200 text-gray-900 p-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs"
                                    placeholder="Achternaam" value="{{ old('last_name') }}">
                                @error('last_name')
                                    <span class="text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- CONTACT --}}
                    <div class="mb-2">
                        <div
                            class="text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1 mt-3 border-t border-gray-200 dark:border-gray-700">
                            Contact</div>
                        <div class="mb-2">
                            <label for="email"
                                class="block text-xs font-medium text-gray-700 dark:text-gray-300">E-mail*</label>
                            <input type="email" name="email" id="email"
                                class="bg-gray-200 text-gray-900 p-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs"
                                placeholder="Email" value="{{ old('email') }}">
                            @if ($errors->has('email') && empty(old('email')))
                                <span class="text-xs text-red-500">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="flex gap-2">
                            <div class="flex-1">
                                <label for="username"
                                    class="block text-xs font-medium text-gray-700 dark:text-gray-300">Gebruikersnaam*</label>
                                <input type="text" name="username" id="username"
                                    class="bg-gray-200 text-gray-900 p-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs"
                                    placeholder="Gebruikersnaam" value="{{ old('username') }}">
                                @if ($errors->has('username') && empty(old('username')))
                                    <span class="text-xs text-red-500">{{ $errors->first('username') }}</span>
                                @endif
                            </div>
                            <div class="flex-1">
                                <label for="birth_date"
                                    class="block text-xs font-medium text-gray-700 dark:text-gray-300">Geboortedatum*</label>
                                <input type="date" name="birth_date" id="birth_date"
                                    class="bg-gray-200 text-gray-900 p-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs"
                                    value="{{ old('birth_date') }}">
                                @error('birth_date')
                                    <span class="text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="flex gap-2 mt-2">
                            <div class="flex-1">
                                <label for="street"
                                    class="block text-xs font-medium text-gray-700 dark:text-gray-300">Straat*</label>
                                <input type="text" name="street" id="street"
                                    class="bg-gray-200 text-gray-900 p-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs"
                                    placeholder="Straat" value="{{ old('street') }}">
                                @error('street')
                                    <span class="text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-24">
                                <label for="house_number"
                                    class="block text-xs font-medium text-gray-700 dark:text-gray-300">Nr*</label>
                                <input type="text" name="house_number" id="house_number"
                                    class="bg-gray-200 text-gray-900 p-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs"
                                    placeholder="Nr" value="{{ old('house_number') }}">
                                @error('house_number')
                                    <span class="text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-32">
                                <label for="postal_code"
                                    class="block text-xs font-medium text-gray-700 dark:text-gray-300">Postcode*</label>
                                <input type="text" name="postal_code" id="postal_code"
                                    class="bg-gray-200 text-gray-900 p-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs"
                                    placeholder="Postcode" value="{{ old('postal_code') }}">
                                @error('postal_code')
                                    <span class="text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex-1">
                                <label for="city"
                                    class="block text-xs font-medium text-gray-700 dark:text-gray-300">Stad*</label>
                                <input type="text" name="city" id="city"
                                    class="bg-gray-200 text-gray-900 p-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs"
                                    placeholder="Stad" value="{{ old('city') }}">
                                @error('city')
                                    <span class="text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- WACHTWOORD --}}
                    <div class="mb-2">
                        <div class="text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1 mt-3">Wachtwoord</div>
                        <div class="flex gap-2">
                            <div class="flex-1">
                                <label for="password"
                                    class="block text-xs font-medium text-gray-700 dark:text-gray-300">Wachtwoord*</label>
                                <input type="password" name="password" id="password"
                                    class="bg-gray-200 text-gray-900 p-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs"
                                    placeholder="Wachtwoord">
                                @error('password')
                                    <span class="text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex-1">
                                <label for="password_confirmation"
                                    class="block text-xs font-medium text-gray-700 dark:text-gray-300">Bevestig
                                    Wachtwoord*</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="bg-gray-200 text-gray-900 p-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs"
                                    placeholder="Bevestig Wachtwoord">
                                @error('password_confirmation')
                                    <span class="text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-4">
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
