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
        <div class="fixed top-5 right-5 z-50">
            <x-theme-toggle />
        </div>

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-gray-800 shadow">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById('theme-toggle');
            const darkIcon = document.getElementById('theme-toggle-dark-icon');
            const lightIcon = document.getElementById('theme-toggle-light-icon');

            console.log('Theme elements:', {
                toggleButton: !!toggleButton,
                darkIcon: !!darkIcon,
                lightIcon: !!lightIcon,
                isDarkMode: document.documentElement.classList.contains('dark')
            });

            // Correctly set initial icon state
            if (document.documentElement.classList.contains('dark')) {
                // In dark mode, show the sun (light) icon
                darkIcon.classList.add('hidden');
                lightIcon.classList.remove('hidden');
            } else {
                // In light mode, show the moon (dark) icon
                darkIcon.classList.remove('hidden');
                lightIcon.classList.add('hidden');
            }

            // Add click handler
            if (toggleButton) {
                toggleButton.addEventListener('click', function() {
                    console.log('Toggle button clicked');

                    // Toggle dark mode class on document
                    document.documentElement.classList.toggle('dark');

                    // Toggle icon visibility
                    darkIcon.classList.toggle('hidden');
                    lightIcon.classList.toggle('hidden');

                    // Update localStorage
                    if (document.documentElement.classList.contains('dark')) {
                        localStorage.setItem('color-theme', 'dark');
                        console.log('Switched to dark mode');
                    } else {
                        localStorage.setItem('color-theme', 'light');
                        console.log('Switched to light mode');
                    }
                });
            }
        });
    </script>
    <!-- Emergency direct toggle for testing -->
    <div class="fixed bottom-5 right-5 z-50">
        <button
            onclick="document.documentElement.classList.toggle('dark'); localStorage.setItem('color-theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');"
            class="bg-white dark:bg-gray-800 p-2 rounded-full shadow-lg text-gray-500 dark:text-gray-400">
            Toggle Dark Mode
        </button>
    </div>
</body>

</html>
