// Simple dark mode toggle functionality
document.addEventListener('DOMContentLoaded', function () {
  // Get the toggle button and icons
  const toggleButton = document.getElementById('theme-toggle');
  const darkIcon = document.getElementById('theme-toggle-dark-icon');
  const lightIcon = document.getElementById('theme-toggle-light-icon');

  // Set initial state based on localStorage or system preference
  if (document.documentElement.classList.contains('dark')) {
    darkIcon?.classList.add('hidden');
    lightIcon?.classList.remove('hidden');
  } else {
    lightIcon?.classList.add('hidden');
    darkIcon?.classList.remove('hidden');
  }

  // Add click event handler to toggle button
  if (toggleButton) {
    toggleButton.addEventListener('click', function () {
      // Toggle dark class on html element
      document.documentElement.classList.toggle('dark');

      // Toggle icons visibility
      darkIcon?.classList.toggle('hidden');
      lightIcon?.classList.toggle('hidden');

      // Save preference to localStorage
      if (document.documentElement.classList.contains('dark')) {
        localStorage.setItem('color-theme', 'dark');
      } else {
        localStorage.setItem('color-theme', 'light');
      }
    });
  }
});