export function initBulkActions() {
  // Bulk actions are primarily handled by Alpine.js in bulk-action-toolbar
  // This file provides additional utility functions if needed

  window.submitBulkDelete = submitBulkDelete;
}

export function submitBulkDelete(resource, selectedIds) {
  if (!selectedIds || selectedIds.length === 0) {
    window.toast?.warning('Sélection vide', 'Veuillez sélectionner au moins un élément');
    return;
  }

  // Create and submit form
  const form = document.createElement('form');
  form.method = 'POST';
  form.action = `/${resource}/bulk-delete`;

  // Add CSRF token
  const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
  if (token) {
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = '_token';
    input.value = token;
    form.appendChild(input);
  }

  // Add selected IDs
  selectedIds.forEach(id => {
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'ids[]';
    input.value = id;
    form.appendChild(input);
  });

  document.body.appendChild(form);
  form.submit();
}
