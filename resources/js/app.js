import './bootstrap';
import { toast } from './toast';
import { initLoadingStates, showLoading, hideLoading } from './loading';

import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';

window.Alpine = Alpine;
window.Chart = Chart;
window.toast = toast; // Make toast available globally
window.showLoading = showLoading;
window.hideLoading = hideLoading;

// Initialize loading states
initLoadingStates();

Alpine.start();
