{{-- Laravel project: \resources\views\layouts\app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Vierkantewielen</title>

    <!-- Script to prevent flash of incorrect theme -->
    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- favicon -->
    <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex flex-col min-h-screen font-sans antialiased bg-white dark:bg-gray-900">
    <div class="flex flex-col flex-grow min-h-screen">
        @include('layouts.navigation')

        <!-- Theme Toggle - moved to a better position in the navigation bar -->
        {{-- <div class="fixed top-5 right-5 z-50">
            <x-theme-toggle />
        </div> --}}

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="flex-grow">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <div class="mt-auto">
            @include('layouts.footer')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- Verwijderd: inline script voor theme toggle, wordt nu door JS-module gedaan --}}
    <!-- Emergency direct toggle for testing -->
    {{-- <div class="fixed bottom-5 right-5 z-50">
        <button
            onclick="document.documentElement.classList.toggle('dark'); localStorage.setItem('color-theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');"
            class="bg-white dark:bg-gray-800 p-2 rounded-full shadow-lg text-gray-500 dark:text-gray-400">
            Toggle Dark Mode
        </button>
    </div> --}}
</body>

</html>
