
let currentTheme = 'auto'; // Track the current theme

function changeTheme(theme, updateCookie = true) {
  currentTheme = theme;

  if (theme === 'auto') {
    const prefersDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
    theme = prefersDarkMode ? 'dark' : 'light';
  }

  document.documentElement.setAttribute('data-bs-theme', theme);

  if (updateCookie) {
    document.cookie = `theme=${currentTheme}; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/`;
  }

  const themeButtons = document.querySelectorAll('[data-bs-theme-value]');
  themeButtons.forEach((button) => {
    button.classList.remove('active');
    const checkmark = button.querySelector('.checkmark');
    if (checkmark) {
      checkmark.classList.add('d-none');
    }
  });

  const activeButton = document.querySelector(`[data-bs-theme-value="${currentTheme}"]`);
  activeButton.classList.add('active');
  const checkmark = activeButton.querySelector('.checkmark');
  if (checkmark) {
    checkmark.classList.remove('d-none');
  }
}

function applySavedTheme() {
  const cookies = document.cookie.split(';');
  for (const cookie of cookies) {
    const [name, value] = cookie.trim().split('=');
    if (name === 'theme') {
      changeTheme(value, false);
      break;
    }
  }
}

document.addEventListener('DOMContentLoaded', applySavedTheme);

document.addEventListener('DOMContentLoaded', () => {
  const lightThemeButton = document.querySelector('[data-bs-theme-value="light"]');
  const darkThemeButton = document.querySelector('[data-bs-theme-value="dark"]');
  const autoThemeButton = document.querySelector('[data-bs-theme-value="auto"]');

  lightThemeButton.addEventListener('click', () => changeTheme('light'));
  darkThemeButton.addEventListener('click', () => changeTheme('dark'));
  autoThemeButton.addEventListener('click', () => changeTheme('auto'));
});

// Listen for changes in the system's color scheme preference
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
  if (currentTheme === 'auto') {
    changeTheme('auto', false); // Update theme without changing the cookie
  }
});


