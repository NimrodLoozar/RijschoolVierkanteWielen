<x-app-layout>
        <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Account aanmaken') }}
            </h2>
            <span class="px-3 py-1 text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full">
                {{ now()->format('d M Y') }}
            </span>
        </div>
    </x-slot>
    <div class="py-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 rounded mb-4 text-sm">
                    <p>{{ session('error') }}</p>
                </div>
            @endif
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 rounded mb-4 text-sm">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            
            
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-5 bg-white">
                    <form method="POST" action="{{ route('accounts.store') }}">
                        @csrf
                        
                        <!-- Hidden field for simulate error -->
                        <input type="hidden" name="simulate_error" id="simulateError" value="0">

                        <!-- Persoonlijke gegevens section -->
                        <div class="mb-4">
                            <h3 class="text-base font-medium text-gray-700 mb-2 pb-1 border-b border-gray-200">{{ __('Persoonlijke gegevens') }}</h3>
                            
                            <!-- Name fields grouped in a flex container on larger screens -->
                            <div class="md:flex md:space-x-3">
                                <!-- First Name -->
                                <div class="mb-2 md:w-1/3">
                                    <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" required autofocus
                                        placeholder="{{ __('Voornaam') }} *"
                                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                                    @error('first_name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Middle Name -->
                                <div class="mb-2 md:w-1/4">
                                    <input id="middle_name" type="text" name="middle_name" value="{{ old('middle_name') }}"
                                        placeholder="{{ __('Tussenvoegsel') }}"
                                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                                    @error('middle_name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Last Name -->
                                <div class="mb-2 md:w-2/5">
                                    <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" required
                                        placeholder="{{ __('Achternaam') }} *"
                                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                                    @error('last_name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Birth Date -->
                            <div class="mb-2">
                                <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date') }}"
                                    placeholder="{{ __('Geboortedatum') }}"
                                    class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                                @error('birth_date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Contact information section -->
                        <div class="mb-4">
                            <h3 class="text-base font-medium text-gray-700 mb-2 pb-1 border-b border-gray-200">{{ __('Contact informatie') }}</h3>
                            
                            <div class="md:flex md:space-x-3">
                                <!-- Email -->
                                <div class="mb-2 md:w-1/2">
                                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                                        placeholder="{{ __('E-mail') }}"
                                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Mobile -->
                                <div class="mb-2 md:w-1/2">
                                    <input id="mobile" type="tel" name="mobile" value="{{ old('mobile') }}"
                                        placeholder="{{ __('Mobiel') }}"
                                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                                    @error('mobile')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Address section -->
                        <div class="mb-4">
                            <h3 class="text-base font-medium text-gray-700 mb-2 pb-1 border-b border-gray-200">{{ __('Adresgegevens') }}</h3>
                            
                            <div class="md:flex md:space-x-3">
                                <!-- Street -->
                                <div class="mb-2 md:w-2/3">
                                    <input id="street" type="text" name="street" value="{{ old('street') }}"
                                        placeholder="{{ __('Straat') }}"
                                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                                    @error('street')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- House Number -->
                                <div class="mb-2 md:w-1/6">
                                    <input id="house_number" type="text" name="house_number" value="{{ old('house_number') }}"
                                        placeholder="{{ __('Nummer') }}"
                                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                                    @error('house_number')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Addition -->
                                <div class="mb-2 md:w-1/6">
                                    <input id="addition" type="text" name="addition" value="{{ old('addition') }}" maxlength="10"
                                        placeholder="{{ __('Toevoeging') }}"
                                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                                    @error('addition')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="md:flex md:space-x-3">
                                <!-- Postal Code -->
                                <div class="mb-2 md:w-1/3">
                                    <input id="postal_code" type="text" name="postal_code" value="{{ old('postal_code') }}" maxlength="6"
                                        placeholder="{{ __('Postcode') }}"
                                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                                    @error('postal_code')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- City -->
                                <div class="mb-2 md:w-2/3">
                                    <input id="city" type="text" name="city" value="{{ old('city') }}"
                                        placeholder="{{ __('Plaats') }}"
                                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                                    @error('city')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Account gegevens section -->
                        <div class="mb-4">
                            <h3 class="text-base font-medium text-gray-700 mb-2 pb-1 border-b border-gray-200">{{ __('Account gegevens') }}</h3>
                            
                            <!-- Username -->
                            <div class="mb-2">
                                <input id="username" type="text" name="username" value="{{ old('username') }}" required
                                    placeholder="{{ __('Gebruikersnaam') }} *"
                                    class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                                @error('username')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password fields grouped -->
                            <div class="md:flex md:space-x-3">
                                <!-- Password -->
                                <div class="mb-2 md:w-1/2">
                                    <div class="relative">
                                        <input id="password" type="password" name="password" required
                                            placeholder="{{ __('Wachtwoord') }} *"
                                            class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                                        <button type="button" class="toggle-password absolute inset-y-0 right-0 pr-2 flex items-center" data-target="password">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </div>
                                    @error('password')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div class="mb-2 md:w-1/2">
                                    <div class="relative">
                                        <input id="password_confirmation" type="password" name="password_confirmation" required
                                            placeholder="{{ __('Bevestig wachtwoord') }} *"
                                            class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                                        <button type="button" class="toggle-password absolute inset-y-0 right-0 pr-2 flex items-center" data-target="password_confirmation">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Extra gegevens section -->
                        <div class="mb-4">
                            <h3 class="text-base font-medium text-gray-700 mb-2 pb-1 border-b border-gray-200">{{ __('Extra gegevens') }}</h3>

                            <div class="flex flex-wrap">
                                <!-- Is Active -->
                                <div class="mb-2 w-full sm:w-1/2">
                                    <label for="is_active" class="flex items-center">
                                        <input id="is_active" type="checkbox" name="is_active" value="1" 
                                            {{ old('is_active', true) ? 'checked' : '' }}
                                            class="h-4 w-4 text-blue-600 rounded focus:ring-1 focus:ring-offset-0 focus:ring-blue-500">
                                        <span class="ml-2 text-xs text-gray-700">{{ __('Account is actief') }}</span>
                                    </label>
                                </div>

                                <!-- Note -->
                                <div class="mb-2 w-full">
                                    <textarea id="note" name="note" rows="2"
                                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500"
                                        placeholder="{{ __('Notitie') }}">{{ old('note') }}</textarea>
                                    @error('note')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="text-xs text-gray-500 mb-2">* Verplichte velden</div>

                        <!-- Developer Tools (Only visible in development) -->
                                <div class="mb-8 bg-yellow-50 p-5 rounded-lg shadow-sm border border-yellow-200">
                                    <h3 class="text-lg font-medium text-yellow-700 mb-4 pb-2 border-b-2 border-yellow-200 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                        </svg>
                                        Developer Tools
                                    </h3>
                                    
                                    <div class="mb-3">
                                        <input type="hidden" name="simulate_error" id="simulate_error_input" value="0">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" id="simulate_error_checkbox" class="hidden">
                                            <span class="relative inline-block w-10 h-5 rounded-full bg-gray-300 transition-colors ease-in-out duration-200 mr-3" id="simulate_error_toggle">
                                                <span class="simulate-error-slider absolute left-0.5 top-0.5 bg-white w-4 h-4 rounded-full transition-transform duration-200 transform"></span>
                                            </span>
                                            <span class="text-sm font-medium text-yellow-700">Simuleer technische fout</span>
                                        </label>
                                        <p class="text-xs text-yellow-600 mt-1">Alleen voor testdoeleinden. Hiermee kun je een fout simuleren tijdens het aanmaken van een factuur.</p>
                                    </div>
                                </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end">
                            <a href="{{ route('accounts.index') }}" class="mr-2 px-3 py-1 text-xs font-medium text-gray-700 hover:text-gray-500">
                                {{ __('Annuleren') }}
                            </a>
                            <button type="submit" class="px-4 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded-md transition duration-150 ease-in-out focus:outline-none focus:ring-1 focus:ring-blue-500 focus:ring-offset-1">
                                {{ __('Account aanmaken') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Password visibility and error toggle script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButtons = document.querySelectorAll('.toggle-password');
            
            // Password visibility toggle
            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const passwordInput = document.getElementById(targetId);
                    
                    // Toggle password visibility
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        
                        // Change to "eye-off" icon
                        this.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        `;
                    } else {
                        passwordInput.type = 'password';
                        // Change back to "eye" icon
                        this.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        `;
                    }
                });
            });
            
           // Toggle functionality for simulate error
            const simulateErrorCheckbox = document.getElementById('simulate_error_checkbox');
            const simulateErrorInput = document.getElementById('simulate_error_input');
            const simulateErrorToggle = document.getElementById('simulate_error_toggle');
            
            if (simulateErrorCheckbox && simulateErrorInput && simulateErrorToggle) {
                simulateErrorCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        simulateErrorInput.value = '1';
                        simulateErrorToggle.classList.remove('bg-gray-300');
                        simulateErrorToggle.classList.add('bg-yellow-500');
                        document.querySelector('.simulate-error-slider').classList.add('translate-x-5');
                    } else {
                        simulateErrorInput.value = '0';
                        simulateErrorToggle.classList.remove('bg-yellow-500');
                        simulateErrorToggle.classList.add('bg-gray-300');
                        document.querySelector('.simulate-error-slider').classList.remove('translate-x-5');
                    }
                });
            }
        });
    </script>
</x-app-layout>