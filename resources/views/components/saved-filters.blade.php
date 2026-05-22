@props(['resource' => 'students'])

<div x-data="savedFilters('{{ $resource }}')" class="relative">
    <button @click="isOpen = !isOpen"
            class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-900 text-sm font-medium">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V5z"/>
        </svg>
        Filtres sauvegardés
        <svg class="w-4 h-4" :class="isOpen ? 'rotate-180' : ''" class="transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <div x-show="isOpen" @click.outside="isOpen = false"
         x-transition
         class="absolute right-0 mt-2 w-72 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg z-40">
        <!-- Save Current Filter -->
        <div class="border-b border-gray-200 dark:border-gray-700 p-4">
            <label class="text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2 block">
                Sauvegarder le filtre actuel
            </label>
            <div class="flex gap-2">
                <input x-model="filterName"
                       @keyup.enter="saveFilter()"
                       placeholder="Nom du filtre"
                       class="flex-1 px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400"
                />
                <button @click="saveFilter()"
                        :disabled="!filterName || filters.length >= 5"
                        class="px-3 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white text-sm font-medium transition-colors duration-200">
                    Ajouter
                </button>
            </div>
            <template x-if="filters.length >= 5">
                <p class="text-xs text-amber-600 dark:text-amber-400 mt-2">Maximum 5 filtres sauvegardés atteint</p>
            </template>
        </div>

        <!-- Saved Filters List -->
        <div class="py-2 max-h-64 overflow-y-auto">
            <template x-if="filters.length === 0">
                <div class="px-4 py-3 text-center text-gray-500 dark:text-gray-400 text-sm">
                    Aucun filtre sauvegardé
                </div>
            </template>

            <template x-for="(filter, index) in filters" :key="index">
                <div class="px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150 border-b border-gray-100 dark:border-gray-700 last:border-0 flex items-center justify-between group">
                    <button @click="applyFilter(filter.params)"
                            class="flex-1 text-left">
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100 line-clamp-1" x-text="filter.name"></div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 line-clamp-1" x-text="filter.description"></div>
                    </button>
                    <button @click="deleteFilter(index)"
                            class="ml-2 text-red-600 dark:text-red-400 opacity-0 group-hover:opacity-100 hover:text-red-700 dark:hover:text-red-300 transition-all duration-150">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
                        </svg>
                    </button>
                </div>
            </template>
        </div>
    </div>
</div>

<script>
function savedFilters(resource) {
    return {
        isOpen: false,
        filters: [],
        filterName: '',
        resource: resource,

        init() {
            this.loadFilters();
        },

        loadFilters() {
            const stored = localStorage.getItem(`saved-filters-${this.resource}`);
            this.filters = stored ? JSON.parse(stored) : [];
        },

        saveFilter() {
            if (!this.filterName.trim()) return;
            if (this.filters.length >= 5) return;

            const params = this.getCurrentParams();
            const description = this.formatDescription(params);

            const filter = {
                name: this.filterName,
                params,
                description,
                createdAt: new Date().toLocaleString('fr-FR')
            };

            // Remove duplicate name
            this.filters = this.filters.filter(f => f.name !== this.filterName);

            this.filters.push(filter);
            localStorage.setItem(`saved-filters-${this.resource}`, JSON.stringify(this.filters));

            this.filterName = '';
            window.toast?.success('Filtre sauvegardé', `"${filter.name}" a été ajouté`);
        },

        applyFilter(params) {
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

        deleteFilter(index) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce filtre ?')) {
                this.filters.splice(index, 1);
                localStorage.setItem(`saved-filters-${this.resource}`, JSON.stringify(this.filters));
            }
        },

        getCurrentParams() {
            const params = {};
            const url = new URL(window.location);
            url.searchParams.forEach((value, key) => {
                if (key !== 'page') {
                    params[key] = value;
                }
            });
            return params;
        },

        formatDescription(params) {
            const parts = [];
            Object.keys(params).forEach(key => {
                if (params[key]) {
                    parts.push(`${key}: ${params[key]}`);
                }
            });
            return parts.length > 0 ? parts.join(', ') : 'Aucun filtre';
        }
    }
}
</script>
