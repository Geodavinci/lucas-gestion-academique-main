<!-- Toast Demo Section (optionnel) -->
<div class="bg-white rounded-2xl shadow-lg border border-gray-100/50 p-8">
    <h2 class="text-2xl font-bold mb-6">Démo Notifications</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <button
            @click="document.dispatchEvent(new CustomEvent('notify', { detail: { id: Math.random(), type: 'success', title: 'Succès!', message: 'Opération réussie', duration: 4000 }}))"
            class="px-4 py-2 rounded-xl bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold hover:shadow-lg transition-all"
        >
            Succès
        </button>

        <button
            @click="document.dispatchEvent(new CustomEvent('notify', { detail: { id: Math.random(), type: 'error', title: 'Erreur!', message: 'Une erreur s\'est produite', duration: 5000 }}))"
            class="px-4 py-2 rounded-xl bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold hover:shadow-lg transition-all"
        >
            Erreur
        </button>

        <button
            @click="document.dispatchEvent(new CustomEvent('notify', { detail: { id: Math.random(), type: 'info', title: 'Information', message: 'Ceci est un message informatif', duration: 4000 }}))"
            class="px-4 py-2 rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold hover:shadow-lg transition-all"
        >
            Info
        </button>

        <button
            @click="document.dispatchEvent(new CustomEvent('notify', { detail: { id: Math.random(), type: 'warning', title: 'Attention', message: 'Ceci est un avertissement', duration: 5000 }}))"
            class="px-4 py-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 text-white font-semibold hover:shadow-lg transition-all"
        >
            Avertissement
        </button>
    </div>
</div>
