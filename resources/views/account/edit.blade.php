<x-layout>
    <h2 class="mt-20 ml-8 font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Account bijwerken') }}
    </h2>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="bg-red-500 text-white p-4 rounded">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="bg-green-500 text-white p-4 rounded">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('accounts.update', $account->id) }}">
                        @csrf
                        @method('PATCH')

                        <!-- First Name -->
                        <div class="mb-4">
                            <label for="first_name" class="block text-sm font-medium text-gray-700">{{ __('Voornaam') }}</label>
                            <input id="first_name" type="text" name="first_name" value="{{ old('first_name', $account->first_name) }}" required autofocus
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('first_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Middle Name -->
                        <div class="mb-4">
                            <label for="middle_name" class="block text-sm font-medium text-gray-700">{{ __('Tussenvoegsel') }}</label>
                            <input id="middle_name" type="text" name="middle_name" value="{{ old('middle_name', $account->middle_name) }}"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('middle_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Last Name -->
                        <div class="mb-4">
                            <label for="last_name" class="block text-sm font-medium text-gray-700">{{ __('Achternaam') }}</label>
                            <input id="last_name" type="text" name="last_name" value="{{ old('last_name', $account->last_name) }}" required
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('last_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Birth Date -->
                        <div class="mb-4">
                            <label for="birth_date" class="block text-sm font-medium text-gray-700">{{ __('Geboortedatum') }}</label>
                            <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date', $account->birth_date) }}"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('birth_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Username -->
                        <div class="mb-4">
                            <label for="username" class="block text-sm font-medium text-gray-700">{{ __('Gebruikersnaam') }}</label>
                            <input id="username" type="text" name="username" value="{{ old('username', $account->username) }}" required
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('username')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Wachtwoord') }}</label>
                            <input id="password" type="password" name="password"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                placeholder="Laat leeg om het huidige wachtwoord te behouden">
                            <p class="text-gray-500 text-xs mt-1">{{ __('Laat leeg om het huidige wachtwoord te behouden') }}</p>
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">{{ __('Bevestig wachtwoord') }}</label>
                            <input id="password_confirmation" type="password" name="password_confirmation"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <!-- Is Active -->
                        <div class="mb-4">
                            <label for="is_active" class="flex items-center">
                                <input id="is_active" type="checkbox" name="is_active" value="1" 
                                    {{ old('is_active', $account->is_active) ? 'checked' : '' }}
                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-600">{{ __('Actief') }}</span>
                            </label>
                        </div>

                        <!-- Note -->
                        <div class="mb-4">
                            <label for="note" class="block text-sm font-medium text-gray-700">{{ __('Notitie') }}</label>
                            <textarea id="note" name="note" rows="3"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('note', $account->note) }}</textarea>
                            @error('note')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('accounts.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-200 disabled:opacity-25 transition ease-in-out duration-150 mr-2">
                                {{ __('Annuleren') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Account bijwerken') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>