<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Auto toevoegen') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 mt-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <form method="POST" action="{{ route('autos.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="brand" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Merk*</label>
                        <select name="brand" id="brand"
                            class="bg-gray-200 text-gray-900 p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            required>
                            <option value="">Selecteer merk</option>
                            @foreach(['Toyota','Ford','BMW','Mercedes','Volkswagen'] as $brand)
                                <option value="{{ $brand }}">{{ $brand }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="model" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Model*</label>
                        <select name="model" id="model"
                            class="bg-gray-200 text-gray-900 p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            required>
                            <option value="">Selecteer eerst een merk</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="fuel" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Brandstof*</label>
                        <select name="fuel" id="fuel"
                            class="bg-gray-200 text-gray-900 p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            required>
                            <option value="">Selecteer eerst een model</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="is_active" class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" checked
                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-600">Actief</span>
                        </label>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            id="submitBtn">
                            Toevoegen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Alleen de 5 werkende auto's
        const brandsWithModelsAndFuel = {
            "Toyota": [
                {model: "Corolla", fuel: ["gasoline"]},
                {model: "Yaris", fuel: ["gasoline"]},
                {model: "Aygo", fuel: ["gasoline"]},
                {model: "Prius", fuel: ["gasoline", "electric"]},
                {model: "RAV4", fuel: ["gasoline"]}
            ],
            "Ford": [
                {model: "Fiesta", fuel: ["gasoline"]},
                {model: "Focus", fuel: ["gasoline"]},
                {model: "Mondeo", fuel: ["gasoline"]},
                {model: "Puma", fuel: ["gasoline"]},
                {model: "Kuga", fuel: ["gasoline"]}
            ],
            "BMW": [
                {model: "320i", fuel: ["gasoline"]},
                {model: "X5", fuel: ["gasoline"]},
                {model: "2015 M5", fuel: ["gasoline"]},
                {model: "i3", fuel: ["electric"]},
                {model: "X1", fuel: ["gasoline"]}
            ],
            "Mercedes": [
                {model: "A-Class", fuel: ["gasoline"]},
                {model: "C-Class", fuel: ["gasoline"]},
                {model: "E-Class", fuel: ["gasoline"]},
                {model: "GLA", fuel: ["gasoline"]},
                {model: "S-Class", fuel: ["gasoline"]}
            ],
            "Volkswagen": [
                {model: "Golf", fuel: ["gasoline"]},
                {model: "Polo", fuel: ["gasoline"]},
                {model: "Passat", fuel: ["gasoline"]},
                {model: "Tiguan", fuel: ["gasoline"]},
                {model: "Up!", fuel: ["gasoline"]}
            ]
        };
        const brandSelect = document.getElementById('brand');
        const modelSelect = document.getElementById('model');
        const fuelSelect = document.getElementById('fuel');
        const submitBtn = document.getElementById('submitBtn');
        const form = document.querySelector('form');

        brandSelect.addEventListener('change', function () {
            modelSelect.innerHTML = '<option value="">Selecteer model</option>';
            fuelSelect.innerHTML = '<option value="">Selecteer eerst een model</option>';
            if (brandsWithModelsAndFuel[this.value]) {
                brandsWithModelsAndFuel[this.value].forEach(function (item) {
                    const option = document.createElement('option');
                    option.value = item.model;
                    option.textContent = item.model;
                    modelSelect.appendChild(option);
                });
            }
            modelSelect.selectedIndex = 0;
            fuelSelect.selectedIndex = 0;
        });

        modelSelect.addEventListener('change', function () {
            const brand = brandSelect.value;
            const model = this.value;
            fuelSelect.innerHTML = '<option value="">Selecteer brandstof</option>';
            if (brandsWithModelsAndFuel[brand]) {
                const found = brandsWithModelsAndFuel[brand].find(item => item.model === model);
                if (found) {
                    found.fuel.forEach(function (fuel) {
                        // Gebruik alleen gasoline of electric als value en label
                        let label = fuel === 'gasoline' ? 'gasoline' : (fuel === 'electric' ? 'electric' : fuel);
                        const option = document.createElement('option');
                        option.value = label;
                        option.textContent = label.charAt(0).toUpperCase() + label.slice(1);
                        fuelSelect.appendChild(option);
                    });
                }
            }
            fuelSelect.selectedIndex = 0;
        });

        form.addEventListener('submit', function (e) {
            const brand = brandSelect.value;
            const model = modelSelect.value;
            const fuel = fuelSelect.value;
            if (!brand || !model || !fuel) {
                e.preventDefault();
                alert('Selecteer een merk, model en brandstof.');
            }
        });
    </script>
</x-app-layout>
