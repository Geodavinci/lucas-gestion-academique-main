@props(['action' => 'delete'])

<div x-data="batchConfirmModal()" class="relative z-50" style="display: none;" @batch-confirm.window="open($event.detail)">
    <div class="fixed inset-0 bg-black/50 transition-opacity" @click="close()"></div>

    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg transform"
                 style="display: none;" @click.stop x-show="isOpen" x-transition>

                <!-- Warning Icon -->
                <div class="bg-gradient-to-r from-amber-50 to-orange-50 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-amber-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c.866 1.5 2.926 2.875 5.303 2.875s4.437-1.375 5.303-2.875m0 0a3.75 3.75 0 1 1-7.5 0m7.5 0a3.75 3.75 0 1 0-7.5 0m0 0h.008v.015h-.008V21m0-3a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-1">
                            <h3 class="text-lg font-semibold text-gray-900" x-text="title"></h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-600" x-text="message"></p>
                                <p class="text-sm font-medium text-gray-900 mt-2">
                                    <span x-text="selectedCount"></span> éléments sélectionnés
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Checkbox for "Don't ask again" -->
                <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 sm:px-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" x-model="dontAskAgain" class="rounded border-gray-300 text-amber-600">
                        <span class="text-sm text-gray-600">Ne plus demander pour cette action</span>
                    </label>
                </div>

                <!-- Action Buttons -->
                <div class="px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 gap-3">
                    <button @click="confirm()"
                            :class="actionType === 'delete' ? 'bg-red-600 hover:bg-red-700 focus:ring-red-500' : 'bg-amber-600 hover:bg-amber-700 focus:ring-amber-500'"
                            class="w-full inline-flex justify-center items-center gap-2 rounded-xl text-white px-4 py-2 font-semibold transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2">
                        <span x-show="!isLoading" x-text="confirmText"></span>
                        <x-loading-spinner x-show="isLoading" />
                    </button>
                    <button @click="close()" :disabled="isLoading"
                            class="w-full inline-flex justify-center rounded-xl border border-gray-300 bg-white px-4 py-2 text-gray-700 font-semibold hover:bg-gray-50 transition-colors duration-200 disabled:opacity-50">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function batchConfirmModal() {
    return {
        isOpen: false,
        isLoading: false,
        title: 'Confirmation',
        message: 'Êtes-vous sûr de cette action ?',
        confirmText: 'Supprimer',
        selectedCount: 0,
        actionType: 'delete',
        dontAskAgain: false,
        callback: null,

        open(detail) {
            this.title = detail.title || 'Confirmation';
            this.message = detail.message || 'Êtes-vous sûr de cette action ?';
            this.confirmText = detail.confirmText || 'Supprimer';
            this.selectedCount = detail.selectedCount || 0;
            this.actionType = detail.actionType || 'delete';
            this.callback = detail.callback || null;
            this.dontAskAgain = false;
            this.isLoading = false;
            this.isOpen = true;

            if (this.dontAskAgain) {
                sessionStorage.setItem(`batch-${this.actionType}-skip`, 'true');
            }
        },

        confirm() {
            if (this.dontAskAgain) {
                sessionStorage.setItem(`batch-${this.actionType}-skip`, 'true');
            }

            this.isLoading = true;
            if (this.callback) {
                this.callback().then(() => {
                    this.isLoading = false;
                    this.close();
                }).catch(() => {
                    this.isLoading = false;
                });
            }
        },

        close() {
            this.isOpen = false;
            this.isLoading = false;
        }
    }
}
</script>
