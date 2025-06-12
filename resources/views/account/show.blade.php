<x-app-layout>
        <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Account') }} #{{ $account->id }}
            </h2>
            <span class="px-3 py-1 text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full">
                {{ now()->format('d M Y') }}
            </span>
        </div>
    </x-slot>
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

            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold">Account Details</h3>
                    <span class="px-3 py-1 text-xs rounded-full {{ $account->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $account->is_active ? 'Actief' : 'Inactief' }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Persoonlijke informatie -->
                    <div class="bg-gray-50 p-4 rounded-md">
                        <h4 class="font-bold text-gray-700 mb-3">Persoonlijke informatie</h4>
                        <div class="grid grid-cols-1 gap-2">
                            <div>
                                <span class="block text-m font-medium text-gray-500">Naam</span>
                                <span class="block">{{ $account->full_name }}</span>
                            </div>
                            <div>
                                <span class="block text-m font-medium text-gray-500">Geboortedatum</span>
                                <span class="block">{{ $account->birth_date ? date('d-m-Y', strtotime($account->birth_date)) : 'Niet geregistreerd' }}</span>
                            </div>
                            <div>
                                <span class="block text-m font-medium text-gray-500">Gebruikersnaam</span>
                                <span class="block">{{ $account->username }}</span>
                            </div>
                            @if(isset($account->note) && !empty($account->note))
                            <div>
                                <span class="block text-m font-medium text-gray-500">Notitie</span>
                                <span class="block">{{ $account->note }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Contact informatie -->
                    <div class="bg-gray-50 p-4 rounded-md">
                        <h4 class="font-bold text-gray-700 mb-3">Contact informatie</h4>
                        <div class="grid grid-cols-1 gap-2">
                            <div>
                                <span class="block text-m font-medium text-gray-500">E-mail</span>
                                @if($account->email)
                                <a href="mailto:{{ $account->email }}" class="block text-blue-600 hover:underline">{{ $account->email }}</a>
                                @else
                                <span class="block text-gray-400">Niet geregistreerd</span>
                                @endif
                            </div>
                            <div>
                                <span class="block text-m font-medium text-gray-500">Mobiel</span>
                                @if($account->mobile)
                                <a href="tel:{{ $account->mobile }}" class="block text-blue-600 hover:underline">{{ $account->mobile }}</a>
                                @else
                                <span class="block text-gray-400">Niet geregistreerd</span>
                                @endif
                            </div>
                        </div>

                        <h4 class="font-bold text-gray-700 mb-3 mt-6">Adresgegevens</h4>
                        <div class="grid grid-cols-1 gap-2">
                            <div>
                                <span class="block text-m font-medium text-gray-500">Straat en huisnummer</span>
                                @if($account->street || $account->house_number)
                                <span class="block">{{ $account->street ?? '' }} {{ $account->house_number ?? '' }}{{ $account->addition ? '-'.$account->addition : '' }}</span>
                                @else
                                <span class="block text-gray-400">Niet geregistreerd</span>
                                @endif
                            </div>
                            <div>
                                <span class="block text-m font-medium text-gray-500">Postcode en plaats</span>
                                @if($account->postal_code || $account->city)
                                <span class="block">{{ $account->postal_code ?? '' }} {{ $account->city ?? '' }}</span>
                                @else
                                <span class="block text-gray-400">Niet geregistreerd</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Accounts actions -->
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('accounts.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded transition duration-200">
                        Terug
                    </a>
                    <a href="{{ route('accounts.edit', $account->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded transition duration-200">
                        Bewerken
                    </a>
                    <form action="{{ route('accounts.destroy', $account->id) }}" method="POST" class="inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded transition duration-200">
                            Verwijderen
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('.delete-form').addEventListener('submit', function(e) {
            e.preventDefault();
            if (confirm('Weet je zeker dat je dit account permanent wilt verwijderen? Dit kan niet ongedaan worden gemaakt!')) {
                this.submit();
            }
        });
    </script>

    <style>
        h2 {
            color: #fff;
        }
    </style>
</x-app-layout>