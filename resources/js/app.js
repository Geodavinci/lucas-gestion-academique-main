import './bootstrap';
import { toast } from './toast';
import { initLoadingStates, showLoading, hideLoading } from './loading';
import { initConfirmations, confirmAction, initBatchActions } from './confirm';
import { initSkeletonLoaders, showTableSkeletons, hideTableSkeletons } from './skeleton';
import { initTheme, setTheme, getTheme, getStoredTheme, toggleTheme } from './theme';
import { initSearch } from './search';

import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';

window.Alpine = Alpine;
window.Chart = Chart;
window.toast = toast;
window.showLoading = showLoading;
window.hideLoading = hideLoading;
window.confirmAction = confirmAction;
window.showTableSkeletons = showTableSkeletons;
window.hideTableSkeletons = hideTableSkeletons;
window.setTheme = setTheme;
window.getTheme = getTheme;
window.getStoredTheme = getStoredTheme;
window.toggleTheme = toggleTheme;

// Initialize theme first (before rendering to prevent flash)
initTheme();

// Initialize other systems
initLoadingStates();
document.addEventListener('DOMContentLoaded', () => {
  initConfirmations();
  initBatchActions();
  initSkeletonLoaders();
  initSearch();
});

Alpine.start();
