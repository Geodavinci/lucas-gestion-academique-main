const STORAGE_KEY = 'app-theme';
const SYSTEM_PREFERENCE = '(prefers-color-scheme: dark)';

export function initTheme() {
  const theme = getStoredTheme();

  if (theme === 'system') {
    applySystemTheme();
    monitorSystemTheme();
  } else if (theme) {
    setTheme(theme);
  } else {
    // Default to system preference
    setTheme('system');
  }
}

export function setTheme(mode) {
  const html = document.documentElement;

  if (mode === 'system') {
    localStorage.setItem(STORAGE_KEY, 'system');
    applySystemTheme();
  } else if (mode === 'dark') {
    localStorage.setItem(STORAGE_KEY, 'dark');
    html.classList.add('dark');
  } else if (mode === 'light') {
    localStorage.setItem(STORAGE_KEY, 'light');
    html.classList.remove('dark');
  }

  // Dispatch event for other components to listen
  window.dispatchEvent(new CustomEvent('theme-changed', {
    detail: { theme: mode }
  }));
}

export function toggleTheme() {
  const current = getTheme();

  if (current === 'light') {
    setTheme('dark');
  } else if (current === 'dark') {
    setTheme('light');
  } else {
    // From system, toggle to opposite
    const isDark = window.matchMedia(SYSTEM_PREFERENCE).matches;
    setTheme(isDark ? 'light' : 'dark');
  }
}

export function getTheme() {
  const stored = getStoredTheme();

  if (stored === 'system') {
    return window.matchMedia(SYSTEM_PREFERENCE).matches ? 'dark' : 'light';
  }

  return stored;
}

export function getStoredTheme() {
  return localStorage.getItem(STORAGE_KEY) || 'system';
}

function applySystemTheme() {
  const html = document.documentElement;
  const isDark = window.matchMedia(SYSTEM_PREFERENCE).matches;

  if (isDark) {
    html.classList.add('dark');
  } else {
    html.classList.remove('dark');
  }
}

function monitorSystemTheme() {
  const mediaQuery = window.matchMedia(SYSTEM_PREFERENCE);

  mediaQuery.addEventListener('change', (e) => {
    const stored = getStoredTheme();
    if (stored === 'system') {
      applySystemTheme();
      window.dispatchEvent(new CustomEvent('theme-changed', {
        detail: { theme: 'system' }
      }));
    }
  });
}

export function getThemeOptions() {
  return [
    { value: 'light', label: 'Clair', icon: 'sun' },
    { value: 'dark', label: 'Sombre', icon: 'moon' },
    { value: 'system', label: 'Système', icon: 'auto' }
  ];
}
