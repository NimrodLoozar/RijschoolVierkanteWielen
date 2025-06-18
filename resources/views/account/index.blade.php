<x-app-layout>
        <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Accounts') }}
            </h2>
            <span class="px-3 py-1 text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full">
                {{ now()->format('d M Y') }}
            </span>
        </div>
    </x-slot>
    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
            <br>
            <div class="flex flex-col space-y-4 md:space-y-0 md:flex-row md:items-center md:space-x-4">
                <!-- Compact Search Form -->
                <div class="w-full md:w-auto">
                    <button id="toggleFilters" class="flex items-center text-blue-600 mb-2 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                        </svg>
                        Filters {{ isset($searchName) || isset($searchUsername) ? '(Actief)' : '' }}
                    </button>
                    
                    <div id="filterSection" class="{{ isset($searchName) || isset($searchUsername) || isset($searchStatus) ? '' : 'hidden' }} bg-gray-50 p-3 rounded-md mb-3">
                        <form method="GET" action="{{ route('accounts.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
                            <div>
                                <input type="text" name="searchName" id="searchName" placeholder="Achternaam" value="{{ $searchName ?? '' }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-600 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div>
                                <input type="text" name="searchUsername" id="searchUsername" placeholder="Gebruikersnaam" value="{{ $searchUsername ?? '' }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-600 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div>
                                <select name="searchStatus" id="searchStatus" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-600 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">Alle statussen</option>
                                    <option value="1" {{ isset($searchStatus) && $searchStatus == '1' ? 'selected' : '' }}>Actief</option>
                                    <option value="0" {{ isset($searchStatus) && $searchStatus == '0' ? 'selected' : '' }}>Inactief</option>
                                </select>
                            </div>
                            <div class="flex gap-2 items-center">
                                <button type="submit" class="flex-1 bg-blue-500 text-white px-3 py-2 rounded-md hover:bg-blue-600">
                                    Zoeken
                                </button>
                                @if($searchName || $searchUsername || isset($searchStatus))
                                    <a href="{{ route('accounts.index') }}" class="flex-1 bg-gray-500 text-white px-3 py-2 rounded-md hover:bg-gray-600 text-center">
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <div class="flex-grow"></div>
                <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-4">
                    <label class="flex items-center">
                        <span class="mr-2 text-white !important" style="color: white !important;">Toon Data</span>
                        <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                            <input type="checkbox" id="dataToggle"
                                class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"
                                checked />
                            <label for="dataToggle"
                                class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                        </div>
                    </label>
                    <a href="{{ route('accounts.create') }}" class="w-full sm:w-auto text-center bg-blue-600 text-white px-5 py-3 rounded-md transition duration-300 hover:bg-green-700 transform hover:scale-105">Account Aanmaken</a>
                </div>
            </div>
        </div>

<div id="dataContainer">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <div class="w-full overflow-x-auto">
                    <div class="bg-white shadow-lg rounded-lg my-6">
                        @if ($paginatedAccounts->isNotEmpty())
                            <div class="overflow-x-auto">
                                <table class="min-w-full table-auto">
                                    <thead>
                                        <tr class="bg-gray-100 text-gray-800 uppercase text-sm font-medium leading-normal">
                                            <th class="py-4 px-2 sm:px-6 text-left">Naam</th>
                                            <th class="py-4 px-2 sm:px-6 text-left">Gebruikersnaam</th>
                                            <th class="py-4 px-2 sm:px-6 text-left hidden sm:table-cell">Geboortedatum</th>
                                            <th class="py-4 px-2 sm:px-6 text-left">Status</th>
                                            <th class="py-4 px-2 sm:px-6 text-center">Acties</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-800 text-sm font-light">
                                        @foreach ($paginatedAccounts as $account)
                                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                <td class="py-3 px-2 sm:px-6 truncate max-w-[100px] sm:max-w-none">{{ $account->full_name }}</td>
                                                <td class="py-3 px-2 sm:px-6 truncate max-w-[100px] sm:max-w-none">{{ $account->username }}</td>
                                                <td class="py-3 px-2 sm:px-6 hidden sm:table-cell">{{ $account->birth_date ? date('d-m-Y', strtotime($account->birth_date)) : 'Onbekend' }}</td>

                                                <td class="py-3 px-2 sm:px-6">
                                                    <span class="{{ $account->is_active ? 'text-green-500 bg-green-100' : 'text-red-500 bg-red-100' }} py-1 px-2 sm:px-3 rounded-full text-xs font-medium">
                                                        {{ $account->is_active ? 'Actief' : 'Inactief' }}
                                                    </span>
                                                </td>
                                                <td class="py-3 px-2 sm:px-6 flex justify-center space-x-1 sm:space-x-2">
                                                    <a href="{{ route('accounts.show', $account->id) }}" class="text-blue-500 hover:underline p-1">ⓘ</a>
                                                    <a href="{{ route('accounts.edit', $account->id) }}" class="text-yellow-500 hover:underline p-1">✎</a>
                                                    <form action="{{ route('accounts.destroy', $account->id) }}" method="POST" class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:underline p-1">🗑️</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-red-500 p-6 text-center mx-auto">Accounts kunnen niet worden geladen, probeer later opnieuw.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-4">
                {{ $paginatedAccounts->links() }}
            </div>
        </div>
    </div>

    <div id="errorContainer" class="py-12 hidden text-center mx-auto">
        <p class="text-red-500">Geen accounts gevonden. Maak een nieuw account aan.</p>
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

    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (confirm('Weet je zeker dat je dit account permanent wilt verwijderen? Dit kan niet ongedaan worden gemaakt!')) {
                this.submit();
            }
        });
    });

    // Toggle filter section
    document.getElementById('toggleFilters').addEventListener('click', function() {
        const filterSection = document.getElementById('filterSection');
        filterSection.classList.toggle('hidden');
    });
</script>

<style>
    h2 {
        color: #fff;
    }

    .toon {
        color: #fff;
    }

    .toggle-checkbox:checked {
        right: 0;
        border-color: #38A169;
    }

    .toggle-checkbox:checked+.toggle-label {
        background-color: #38A169;
    }

    .overflow-x-auto {
        overflow-x: auto;
    }
    
    @media (max-width: 640px) {
        table {
            font-size: 0.8rem;
        }
        
        .toggle-checkbox {
            transform: scale(0.9);
        }
        
        input[type="text"] {
            padding: 0.4rem;
            min-width: unset;
            width: 100%;
        }
    }
    
    input[type="text"] {
        padding: 0.5rem;
        min-width: 150px;
    }
</style>