@props(['resource' => 'students'])

<div x-data="bulkActionToolbar('{{ $resource }}')"
     x-show="selectedCount > 0"
     x-transition
     class="fixed bottom-0 left-0 right-0 bg-blue-50 dark:bg-blue-900/20 border-t border-blue-200 dark:border-blue-800 backdrop-blur-sm z-40 shadow-2xl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                <span x-text="selectedCount"></span>
                <span x-text="selectedCount === 1 ? 'élément sélectionné' : 'éléments sélectionnés'"></span>
            </div>

            <select @change="performAction($event.target.value)"
                    class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Actions en masse...</option>
                <option value="delete">Supprimer les sélections</option>
            </select>
        </div>

        <button @click="clearSelection()"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200 text-sm font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Annuler
        </button>
    </div>
</div>

<script>
function bulkActionToolbar(resource) {
    return {
        resource: resource,
        selectedCount: 0,
        selectedIds: [],

        init() {
            this.initializeTable();
            this.setupEventListeners();
        },

        initializeTable() {
            const table = document.querySelector(`[data-resource="${this.resource}"]`);
            if (!table) return;

            // Add checkbox column header
            const thead = table.querySelector('thead tr');
            if (thead && !thead.querySelector('.select-all-checkbox')) {
                const th = document.createElement('th');
                th.className = 'px-4 py-3 w-12';
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.className = 'select-all-checkbox rounded border-gray-300 dark:border-gray-600 text-blue-600 dark:text-blue-500';
                checkbox.addEventListener('change', (e) => this.selectAllRows(e.target.checked, table));
                th.appendChild(checkbox);
                thead.insertBefore(th, thead.firstChild);
            }

            // Add checkbox column to rows
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach(row => {
                if (!row.querySelector('.row-checkbox')) {
                    const td = document.createElement('td');
                    td.className = 'px-4 py-3 w-12';
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.className = 'row-checkbox rounded border-gray-300 dark:border-gray-600 text-blue-600 dark:text-blue-500';
                    checkbox.addEventListener('change', () => this.updateSelection(table));
                    td.appendChild(checkbox);
                    row.insertBefore(td, row.firstChild);
                }
            });
        },

        setupEventListeners() {
            const table = document.querySelector(`[data-resource="${this.resource}"]`);
            if (!table) return;

            const checkboxes = table.querySelectorAll('.row-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', () => this.updateSelection(table));
            });
        },

        updateSelection(table) {
            const selected = Array.from(table.querySelectorAll('.row-checkbox:checked'));
            this.selectedCount = selected.length;
            this.selectedIds = selected.map(cb => {
                const row = cb.closest('tr');
                const idCell = row.querySelector('[data-item-id]');
                return idCell?.getAttribute('data-item-id') || '';
            }).filter(id => id);

            // Update select-all checkbox
            const selectAllCheckbox = table.querySelector('.select-all-checkbox');
            const totalCheckboxes = table.querySelectorAll('.row-checkbox').length;
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = this.selectedCount === totalCheckboxes && totalCheckboxes > 0;
                selectAllCheckbox.indeterminate = this.selectedCount > 0 && this.selectedCount < totalCheckboxes;
            }
        },

        selectAllRows(checked, table) {
            const checkboxes = table.querySelectorAll('.row-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = checked;
            });
            this.updateSelection(table);
        },

        performAction(action) {
            if (!action) return;

            if (action === 'delete') {
                this.bulkDelete();
            }
        },

        bulkDelete() {
            if (this.selectedIds.length === 0) {
                window.toast?.warning('Sélection vide', 'Veuillez sélectionner au moins un élément');
                return;
            }

            // Dispatch batch confirmation
            window.dispatchEvent(new CustomEvent('batch-confirm', {
                detail: {
                    selectedCount: this.selectedIds.length,
                    action: 'delete',
                    callback: () => this.submitBulkDelete()
                }
            }));
        },

        submitBulkDelete() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/{{ $resource }}/bulk-delete`;

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
            this.selectedIds.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = id;
                form.appendChild(input);
            });

            document.body.appendChild(form);
            form.submit();
        },

        clearSelection() {
            const table = document.querySelector(`[data-resource="${this.resource}"]`);
            if (!table) return;

            const checkboxes = table.querySelectorAll('.row-checkbox, .select-all-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });

            this.selectedCount = 0;
            this.selectedIds = [];
        }
    }
}
</script>
