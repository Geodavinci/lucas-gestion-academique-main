/**
 * Toast notification helper
 */

export function showToast(type, title, message = '', duration = 4000) {
    const id = Math.random();

    document.dispatchEvent(new CustomEvent('notify', {
        detail: {
            id,
            type,
            title,
            message: message || '',
            duration
        }
    }));

    return id;
}

export const toast = {
    success: (title, message = '', duration = 4000) => showToast('success', title, message, duration),
    error: (title, message = '', duration = 5000) => showToast('error', title, message, duration),
    info: (title, message = '', duration = 4000) => showToast('info', title, message, duration),
    warning: (title, message = '', duration = 5000) => showToast('warning', title, message, duration),
};

// Auto-show toasts on fetch/form submission
document.addEventListener('DOMContentLoaded', () => {
    // Handle form submissions
    document.addEventListener('submit', (e) => {
        const form = e.target;

        // Disable button during submission
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        }

        // Re-enable on complete
        const reEnableBtn = () => {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        };

        // If form has no action or target="_self", it will reload
        // Show success after reload if there's a success message in session
        const originalOnLoad = window.onload;
        window.onload = () => {
            if (originalOnLoad) originalOnLoad();
            reEnableBtn();
        };

        // Timeout fallback
        setTimeout(reEnableBtn, 5000);
    }, true);
});
