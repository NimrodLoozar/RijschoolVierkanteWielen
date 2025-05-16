<x-layout>
    <h2 class="mt-20 ml-8 font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Factuur aanmaken') }}
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
</div>
</x-layout>