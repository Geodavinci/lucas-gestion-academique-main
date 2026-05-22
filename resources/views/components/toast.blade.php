<!-- Toast Container -->
<div class="fixed bottom-4 right-4 space-y-3 max-w-sm z-50" x-data="{ toasts: [] }" @notify="toasts.push($event.detail); setTimeout(() => toasts = toasts.filter(t => t.id !== $event.detail.id), $event.detail.duration || 4000)">
    <template x-for="toast in toasts" :key="toast.id">
        <div
            :class="{
                'bg-green-50 border-l-4 border-green-500 text-green-800': toast.type === 'success',
                'bg-red-50 border-l-4 border-red-500 text-red-800': toast.type === 'error',
                'bg-blue-50 border-l-4 border-blue-500 text-blue-800': toast.type === 'info',
                'bg-amber-50 border-l-4 border-amber-500 text-amber-800': toast.type === 'warning'
            }"
            class="p-4 rounded-lg shadow-lg backdrop-blur-sm border border-gray-200/50 animate-slideUp"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-2"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0 transform translate-y-2"
        >
            <div class="flex items-start justify-between gap-3">
                <div class="flex items-start gap-3 flex-1">
                    <!-- Icon -->
                    <div :class="{
                        'text-green-500': toast.type === 'success',
                        'text-red-500': toast.type === 'error',
                        'text-blue-500': toast.type === 'info',
                        'text-amber-500': toast.type === 'warning'
                    }" class="flex-shrink-0 mt-0.5">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <template x-if="toast.type === 'success'">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </template>
                            <template x-if="toast.type === 'error'">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </template>
                            <template x-if="toast.type === 'info'">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </template>
                            <template x-if="toast.type === 'warning'">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </template>
                        </svg>
                    </div>

                    <!-- Message -->
                    <div class="flex-1">
                        <h3 class="font-semibold text-sm" x-text="toast.title"></h3>
                        <p class="text-sm mt-1 opacity-90" x-text="toast.message" x-show="toast.message"></p>
                    </div>
                </div>

                <!-- Close Button -->
                <button
                    @click="toasts = toasts.filter(t => t.id !== toast.id)"
                    class="text-gray-400 hover:text-gray-600 transition-colors flex-shrink-0"
                >
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>

            <!-- Progress bar -->
            <div class="mt-2 h-1 bg-gray-200/30 rounded-full overflow-hidden">
                <div
                    :style="{ animation: `shrink ${toast.duration || 4000}ms linear forwards` }"
                    :class="{
                        'bg-green-500': toast.type === 'success',
                        'bg-red-500': toast.type === 'error',
                        'bg-blue-500': toast.type === 'info',
                        'bg-amber-500': toast.type === 'warning'
                    }"
                    class="h-full rounded-full"
                ></div>
            </div>
        </div>
    </template>
</div>

<style>
@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(1rem);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes shrink {
    from {
        width: 100%;
    }
    to {
        width: 0%;
    }
}

.animate-slideUp {
    animation: slideUp 0.3s ease-out;
}
</style>
