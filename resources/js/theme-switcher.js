export const ThemeSwitcher = {
  setDarkClass: () => {
    let isDark = localStorage.theme === 'dark' ||
      (!('theme' in localStorage) &&
        window.matchMedia('(prefers-color-scheme: dark)').matches)

    isDark
      ? document.documentElement.classList.add('dark')
      : document.documentElement.classList.remove('dark')
  },

  init: () => {
    ThemeSwitcher.setDarkClass()
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', ThemeSwitcher.setDarkClass)
    window.ThemeSwitcher = ThemeSwitcher
  }
}
