@props([
    'isDanger' => true,
])

<x-modal :show="false" name="confirm-modal" maxWidth="md">
    <div x-data="{ pending: false }" class="p-6">
        <!-- Icon -->
        <div class="flex justify-center mb-4">
            <div class="rounded-full p-4 {{ $isDanger ? 'bg-red-100' : 'bg-amber-100' }}">
                <svg class="w-8 h-8 {{ $isDanger ? 'text-red-600' : 'text-amber-600' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>

        <!-- Title and Message -->
        <div class="text-center mb-6">
            <h3 id="modal-title" class="text-lg font-bold text-gray-900 mb-2">
                Confirmation
            </h3>
            <p id="modal-message" class="text-gray-600 text-sm">
                Êtes-vous sûr ?
            </p>
        </div>

        <!-- Buttons -->
        <div class="flex gap-3 justify-end">
            <button
                @click="$dispatch('close-modal', 'confirm-modal')"
                :disabled="pending"
                class="px-4 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors duration-200 font-semibold disabled:opacity-50 disabled:cursor-not-allowed"
            >
                Annuler
            </button>
            <button
                @click="pending = true; document.getElementById('pending-form')?.submit()"
                x-bind:class="pending ? 'opacity-60 cursor-not-allowed' : ''"
                :disabled="pending"
                id="confirm-button"
                class="px-4 py-2.5 rounded-lg font-semibold text-white transition-all duration-200 disabled:opacity-60 disabled:cursor-not-allowed inline-flex items-center gap-2"
            >
                <svg x-show="pending" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span id="confirm-text">Supprimer</span>
            </button>
        </div>
    </div>
</x-modal>
