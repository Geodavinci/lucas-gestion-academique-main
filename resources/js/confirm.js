let pendingForm = null;

export function initConfirmations() {
  const forms = document.querySelectorAll('form[data-confirm]');

  forms.forEach(form => {
    form.addEventListener('submit', (e) => {
      e.preventDefault();

      const message = form.getAttribute('data-confirm');
      const title = form.getAttribute('data-confirm-title') || 'Confirmation';
      const confirmText = form.getAttribute('data-confirm-text') || 'Supprimer';
      const isDanger = form.getAttribute('data-confirm-danger') !== 'false';

      // Store the form to submit later
      pendingForm = form;

      // Update modal content
      document.getElementById('modal-title').textContent = title;
      document.getElementById('modal-message').textContent = message;
      document.getElementById('confirm-text').textContent = confirmText;
      document.getElementById('confirm-button').className = isDanger
        ? 'px-4 py-2.5 rounded-lg font-semibold text-white transition-all duration-200 disabled:opacity-60 disabled:cursor-not-allowed inline-flex items-center gap-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 active:scale-95'
        : 'px-4 py-2.5 rounded-lg font-semibold text-white transition-all duration-200 disabled:opacity-60 disabled:cursor-not-allowed inline-flex items-center gap-2 bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 active:scale-95';

      // Set hidden form ID for modal button
      document.getElementById('pending-form').value = '';

      // Open modal via Alpine.js event
      window.dispatchEvent(new CustomEvent('open-modal', { detail: 'confirm-modal' }));
    });
  });

  // Handle confirm button click
  document.getElementById('confirm-button')?.addEventListener('click', (e) => {
    if (pendingForm) {
      // Disable form to prevent double submission
      const buttons = pendingForm.querySelectorAll('button[type="submit"]');
      buttons.forEach(btn => btn.disabled = true);

      // Show loading state on the confirm button
      const spinner = document.querySelector('#confirm-button svg');
      const text = document.querySelector('#confirm-button span');
      if (spinner) spinner.style.display = 'block';

      // Get the form reference before it potentially disappears
      const formToSubmit = pendingForm;

      // Add event listener to clear on response
      const handleResponse = () => {
        const spinner = document.querySelector('#confirm-button svg');
        const buttons = formToSubmit.querySelectorAll('button[type="submit"]');
        buttons.forEach(btn => btn.disabled = false);
        pendingForm = null;
        document.removeEventListener('DOMContentLoaded', handleResponse);
      };

      // Submit after a brief delay to ensure modal closes
      setTimeout(() => {
        formToSubmit.dispatchEvent(new Event('submit', { bubbles: true }));
        const realSubmitEvent = new Event('submit', { bubbles: true, cancelable: true });
        const submitAllowed = formToSubmit.dispatchEvent(realSubmitEvent);
        if (submitAllowed && !realSubmitEvent.defaultPrevented) {
          formToSubmit.submit();
        }
      }, 50);
    }
  });
}

// For direct confirmations (not form-based)
export function confirmAction(message, callback, options = {}) {
  const {
    title = 'Confirmation',
    confirmText = 'Confirmer',
    isDanger = true
  } = options;

  // Update modal content
  document.getElementById('modal-title').textContent = title;
  document.getElementById('modal-message').textContent = message;
  document.getElementById('confirm-text').textContent = confirmText;
  document.getElementById('confirm-button').className = isDanger
    ? 'px-4 py-2.5 rounded-lg font-semibold text-white transition-all duration-200 disabled:opacity-60 disabled:cursor-not-allowed inline-flex items-center gap-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 active:scale-95'
    : 'px-4 py-2.5 rounded-lg font-semibold text-white transition-all duration-200 disabled:opacity-60 disabled:cursor-not-allowed inline-flex items-center gap-2 bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 active:scale-95';

  // Store callback
  window._pendingCallback = callback;

  // Open modal
  window.dispatchEvent(new CustomEvent('open-modal', { detail: 'confirm-modal' }));
}

// For batch confirmations
export function initBatchActions() {
  document.addEventListener('batch-confirm', (e) => {
    const { selectedCount = 0, action = 'delete', callback } = e.detail;

    if (shouldSkipBatchConfirm(action)) {
      if (callback) callback();
      return;
    }

    // Dispatch to batch modal
    window.dispatchEvent(new CustomEvent('batch-confirm', {
      detail: {
        title: getBatchTitle(action, selectedCount),
        message: getBatchMessage(action, selectedCount),
        confirmText: getBatchConfirmText(action),
        selectedCount,
        actionType: action,
        callback
      }
    }));
  });
}

function getBatchTitle(action, count) {
  if (action === 'delete') {
    return `Supprimer ${count} élément${count > 1 ? 's' : ''}`;
  }
  return `Confirmer l'action`;
}

function getBatchMessage(action, count) {
  if (action === 'delete') {
    return `Cette action supprimera ${count} élément${count > 1 ? 's' : ''} de façon permanente. Cette action ne peut pas être annulée.`;
  }
  return `Êtes-vous sûr de vouloir effectuer cette action sur ${count} éléments?`;
}

function getBatchConfirmText(action) {
  if (action === 'delete') return 'Supprimer tous';
  return 'Confirmer';
}

function shouldSkipBatchConfirm(action) {
  return sessionStorage.getItem(`batch-${action}-skip`) === 'true';
}

export function submitBatchAction(form, selectedIds, action = 'delete') {
  if (selectedIds.length === 0) {
    toast.warning('Aucun élément sélectionné', 'Veuillez sélectionner au moins un élément');
    return;
  }

  // Dispatch batch confirmation event
  document.dispatchEvent(new CustomEvent('batch-confirm', {
    detail: {
      selectedCount: selectedIds.length,
      action,
      callback: () => {
        // Add selected IDs to form
        selectedIds.forEach(id => {
          const input = document.createElement('input');
          input.type = 'hidden';
          input.name = 'ids[]';
          input.value = id;
          form.appendChild(input);
        });

        // Submit form
        form.submit();
      }
    }
  }));
}
