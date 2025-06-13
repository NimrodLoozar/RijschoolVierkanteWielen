// Laravel project: \resources\js\theme-toggle.js
// Simple dark mode toggle functionality

function initThemeToggle() {
  const toggleButtons = document.querySelectorAll('.theme-toggle');
  toggleButtons.forEach(toggleButton => {
    const darkIcon = toggleButton.querySelector('#theme-toggle-dark-icon');
    const lightIcon = toggleButton.querySelector('#theme-toggle-light-icon');

    if (!darkIcon || !lightIcon) return;

    // Set initial state based on localStorage or system preference
    if (document.documentElement.classList.contains('dark')) {
      darkIcon.classList.add('hidden');
      lightIcon.classList.remove('hidden');
    } else {
      lightIcon.classList.add('hidden');
      darkIcon.classList.remove('hidden');
    }

    // Remove previous event listeners if any
    toggleButton.onclick = null;

    // Add click event handler to toggle button
    toggleButton.addEventListener('click', function () {
      document.documentElement.classList.toggle('dark');
      darkIcon.classList.toggle('hidden');
      lightIcon.classList.toggle('hidden');
      if (document.documentElement.classList.contains('dark')) {
        localStorage.setItem('color-theme', 'dark');
      } else {
        localStorage.setItem('color-theme', 'light');
      }
    });
  });
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initThemeToggle);
} else {
  initThemeToggle();
}