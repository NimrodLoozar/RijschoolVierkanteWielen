{{-- Laravel project: \resources\views\components\theme-toggle.blade.php --}}
<button id="theme-toggle" type="button"
    class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 bg-white dark:bg-gray-800"
    aria-label="Toggle dark mode">
    <!-- Sun icon (shown in dark mode to switch to light) -->
    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
        xmlns="http://www.w3.org/2000/svg">
        <path
            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
            fill-rule="evenodd" clip-rule="evenodd"></path>
    </svg>

    <!-- Moon icon (shown in light mode to switch to dark) -->
    <svg id="theme-toggle-dark-icon" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
        xmlns="http://www.w3.org/2000/svg">
        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
    </svg>
</button>

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
