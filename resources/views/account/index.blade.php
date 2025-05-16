<x-layout>
    <h2 class="mt-24 ml-4 sm:ml-8 font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Accounts') }}
    </h2>
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
            <div class="flex flex-col space-y-4 md:space-y-0 md:flex-row md:items-center md:space-x-4">
            <!-- Zoek form -->
                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                    <input type="text" id="searchName" placeholder="naam" 
                        class="w-full sm:w-auto rounded-md border-gray-900 shadow-sm focus:border-indigo-600 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <input type="text" id="searchUsername" placeholder="gebruikersnaam" 
                        class="w-full sm:w-auto rounded-md border-gray-900 shadow-sm focus:border-indigo-600 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>

                <div class="flex-grow"></div>
                <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-4">
                    <label class="flex items-center">
                        <span class="mr-2 text-black !important" style="color: black !important;">Toon Data</span>
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
                                            <th class="py-4 px-2 sm:px-6 text-left">Acties</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-800 text-sm font-light">
                                        @foreach ($paginatedAccounts as $account)
                                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                <td class="py-3 px-2 sm:px-6 truncate max-w-[100px] sm:max-w-none">{{ $account->full_name }}</td>
                                                <td class="py-3 px-2 sm:px-6 truncate max-w-[100px] sm:max-w-none">{{ $account->username }}</td>
                                                <td class="py-3 px-2 sm:px-6 hidden sm:table-cell">{{ $account->birth_date ? date('d-m-Y', strtotime($account->birth_date)) : 'Onbekend' }}</td>

                                                <td class="py-3 px-2 sm:px-6">
                                                    <span class="text-white py-1 px-2 sm:px-3 rounded-full text-xs font-medium 
                                                    {{ $account->is_active ? 
                                                    'bg-green-500 text-white py-1 px-3 rounded-full text-xs font-medium' 
                                                    : 'bg-red-500  text-white py-1 px-3 rounded-full text-xs font-medium' }}">
                                                        {{ $account->is_active ? 'Actief' : 'Inactief' }}
                                                    </span>
                                                </td>
                                                <td class="py-3 px-2 sm:px-6 flex space-x-1 sm:space-x-2">
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
        <p class="text-red-500">Geen accounts gevonden. Probeer later opnieuw.</p>
    </div>
</div>
</x-layout>

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

    function performSearch() {
        const nameSearch = document.getElementById('searchName').value.toLowerCase();
        const usernameSearch = document.getElementById('searchUsername').value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        let foundAny = false;

        rows.forEach(row => {
            const name = row.querySelector('td:first-child').textContent.toLowerCase();
            const username = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const matchName = name.includes(nameSearch);
            const matchUsername = username.includes(usernameSearch);
            
            if ((nameSearch === '' || matchName) && (usernameSearch === '' || matchUsername)) {
                row.style.display = '';
                foundAny = true;
            } else {
                row.style.display = 'none';
            }
        });
        
        const noResultsMsg = document.getElementById('noResultsMessage');
        if (!noResultsMsg) {
            const table = document.querySelector('table');
            const noResults = document.createElement('div');
            noResults.id = 'noResultsMessage';
            noResults.className = 'p-4 text-center text-red-500 hidden';
            noResults.innerText = 'Geen accounts gevonden die voldoen aan de zoekcriteria.';
            table.parentNode.insertBefore(noResults, table.nextSibling);
        }
        
        document.getElementById('noResultsMessage').style.display = foundAny ? 'none' : 'block';
    }

    document.getElementById('searchName').addEventListener('input', performSearch);
    document.getElementById('searchUsername').addEventListener('input', performSearch);

    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (confirm('Weet je zeker dat je dit account permanent wilt verwijderen? Dit kan niet ongedaan worden gemaakt!')) {
                this.submit();
            }
        });
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