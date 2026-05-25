@props(['resource' => 'students'])

<div x-data="searchHistory('{{ $resource }}')" class="relative">
    <button @click="isOpen = !isOpen"
            class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-900 text-sm font-medium">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Historique
        <svg class="w-4 h-4" :class="isOpen ? 'rotate-180' : ''" class="transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <div x-show="isOpen" @click.outside="isOpen = false"
         x-transition
         class="absolute left-0 mt-2 w-64 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg z-40">
        <div class="py-2 max-h-64 overflow-y-auto">
            <template x-if="searches.length === 0">
                <div class="px-4 py-3 text-center text-gray-500 dark:text-gray-400 text-sm">
                    Aucune recherche récente
                </div>
            </template>

            <template x-for="(search, index) in searches" :key="index">
                <button @click="applySearch(search.params)"
                        class="w-full text-left px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150 border-b border-gray-100 dark:border-gray-700 last:border-0">
                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100 line-clamp-1" x-text="search.label"></div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1" x-text="search.time"></div>
                </button>
            </template>
        </div>

        <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-2">
            <button @click="clearHistory()"
                    class="w-full text-sm text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 py-1 font-medium transition-colors duration-150">
                Effacer l'historique
            </button>
        </div>
    </div>
</div>

<script>
function searchHistory(resource) {
    return {
        isOpen: false,
        searches: [],
        resource: resource,

        init() {
            this.loadHistory();
        },

        loadHistory() {
            const stored = localStorage.getItem(`search-history-${this.resource}`);
            this.searches = stored ? JSON.parse(stored) : [];
        },

        saveSearch(params) {
            const label = this.formatLabel(params);
            const search = {
                label,
                params,
                time: new Date().toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' })
            };

            // Remove duplicate if exists
            this.searches = this.searches.filter(s => s.label !== label);

            // Add to beginning
            this.searches.unshift(search);

            // Keep only last 10
            if (this.searches.length > 10) {
                this.searches = this.searches.slice(0, 10);
            }

            localStorage.setItem(`search-history-${this.resource}`, JSON.stringify(this.searches));
        },

        applySearch(params) {
            const url = new URL(window.location);
            Object.keys(params).forEach(key => {
                if (params[key]) {
                    url.searchParams.set(key, params[key]);
                } else {
                    url.searchParams.delete(key);
                }
            });
            window.location = url.toString();
        },

        clearHistory() {
            if (confirm('Êtes-vous sûr de vouloir effacer tout l\'historique de recherche ?')) {
                this.searches = [];
                localStorage.removeItem(`search-history-${this.resource}`);
                this.isOpen = false;
            }
        },

        formatLabel(params) {
            const parts = [];
            Object.keys(params).forEach(key => {
                if (params[key]) {
                    parts.push(`${key}: ${params[key]}`);
                }
            });
            return parts.length > 0 ? parts.join(', ') : 'Recherche vide';
        }
    }
}

// Auto-save searches on form submit
document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('form.filter-form');
    forms.forEach(form => {
        form.addEventListener('submit', () => {
            const resource = form.getAttribute('data-resource') || 'students';
            const params = {};
            new FormData(form).forEach((value, key) => {
                params[key] = value;
            });
            // Note: This would require window.searchHistory to be exposed globally
        });
    });
});
</script>
