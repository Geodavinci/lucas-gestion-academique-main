/**
 * Loading State Handler
 * Automatically manages loading states on form submission
 */

export function initLoadingStates() {
    document.addEventListener('submit', (e) => {
        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');

        if (!submitBtn) return;

        // Store original button content
        const originalHTML = submitBtn.innerHTML;
        const originalText = submitBtn.textContent;

        // Add loading state
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-60', 'cursor-not-allowed', 'pointer-events-none');

        // Add loading spinner
        const spinner = document.createElement('span');
        spinner.className = 'inline-flex items-center gap-2';
        spinner.innerHTML = `
            <svg class="w-4 h-4 text-current animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Traitement...</span>
        `;
        submitBtn.innerHTML = '';
        submitBtn.appendChild(spinner);

        // Re-enable button after delay (in case of error)
        const timeoutId = setTimeout(() => {
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-60', 'cursor-not-allowed', 'pointer-events-none');
            submitBtn.innerHTML = originalHTML;
        }, 10000); // 10 seconds

        // Remove timeout if form actually submits
        const originalOnBeforeUnload = window.onbeforeunload;
        window.onbeforeunload = () => {
            clearTimeout(timeoutId);
            window.onbeforeunload = originalOnBeforeUnload;
        };
    }, true);
}

// Initialize on page load
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLoadingStates);
} else {
    initLoadingStates();
}

/**
 * Show loading state on a specific element
 */
export function showLoading(element, text = 'Chargement...') {
    if (!element) return;

    element.disabled = true;
    element.classList.add('opacity-60', 'cursor-not-allowed', 'pointer-events-none');

    const originalHTML = element.innerHTML;
    element.dataset.originalHTML = originalHTML;

    element.innerHTML = `
        <svg class="w-4 h-4 text-current animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span>${text}</span>
    `;
}

/**
 * Hide loading state
 */
export function hideLoading(element) {
    if (!element) return;

    element.disabled = false;
    element.classList.remove('opacity-60', 'cursor-not-allowed', 'pointer-events-none');

    if (element.dataset.originalHTML) {
        element.innerHTML = element.dataset.originalHTML;
        delete element.dataset.originalHTML;
    }
}

// Make functions globally available
window.showLoading = showLoading;
window.hideLoading = hideLoading;
