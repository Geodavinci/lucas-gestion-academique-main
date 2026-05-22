export function initSearch() {
  const forms = document.querySelectorAll('form.filter-form');

  forms.forEach(form => {
    const resource = form.getAttribute('data-resource') || 'students';

    form.addEventListener('submit', () => {
      const params = {};
      new FormData(form).forEach((value, key) => {
        params[key] = value;
      });

      // Save to history
      saveToSearchHistory(resource, params);
    });
  });
}

export function saveToSearchHistory(resource, params) {
  const stored = localStorage.getItem(`search-history-${resource}`);
  let history = stored ? JSON.parse(stored) : [];

  const label = formatLabel(params);
  const search = {
    label,
    params,
    time: new Date().toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' })
  };

  // Remove duplicate if exists
  history = history.filter(s => s.label !== label);

  // Add to beginning
  history.unshift(search);

  // Keep only last 10
  if (history.length > 10) {
    history = history.slice(0, 10);
  }

  localStorage.setItem(`search-history-${resource}`, JSON.stringify(history));
}

function formatLabel(params) {
  const parts = [];
  Object.keys(params).forEach(key => {
    if (params[key]) {
      parts.push(`${key}: ${params[key]}`);
    }
  });
  return parts.length > 0 ? parts.join(', ') : 'Recherche vide';
}

export function loadSearchHistory(resource) {
  const stored = localStorage.getItem(`search-history-${resource}`);
  return stored ? JSON.parse(stored) : [];
}

export function clearSearchHistory(resource) {
  localStorage.removeItem(`search-history-${resource}`);
}
