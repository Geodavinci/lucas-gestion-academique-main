@props(['class' => ''])

<div x-data="themeToggle()" class="{{ $class }}">
    <!-- Theme Toggle Button -->
    <div class="relative inline-block">
        <button @click="isOpen = !isOpen"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-800 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-900"
                :aria-label="'Thème: ' + currentTheme">
            <svg x-show="currentTheme === 'light'" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 18a6 6 0 1 1 0-12 6 6 0 0 1 0 12zM12 2v4m0 8v4M5.64 5.64l2.83 2.83m2 2l2.83 2.83M2 12h4m8 0h4m-11.36 6.36l2.83-2.83m2 2l2.83-2.83" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            </svg>
            <svg x-show="currentTheme === 'dark'" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M21.64 15.95a.75.75 0 0 0-.04-1.06A9.75 9.75 0 0 1 9.11 2.4a.75.75 0 0 0-.98.98 8.25 8.25 0 1 0 12.51 12.57.75.75 0 0 0 1 0z" fill="currentColor"/>
            </svg>
            <span x-text="currentTheme === 'system' ? 'Auto' : (currentTheme === 'light' ? 'Clair' : 'Sombre')" class="text-sm font-medium"></span>
            <svg class="w-4 h-4" x-show="isOpen" x-transition fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
            </svg>
            <svg class="w-4 h-4" x-show="!isOpen" x-transition fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <!-- Dropdown Menu -->
        <div x-show="isOpen" @click.outside="isOpen = false"
             x-transition
             class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg z-50">
            <div class="py-2">
                <button @click="selectTheme('light')"
                        :class="currentTheme === 'light' ? 'bg-blue-50 dark:bg-blue-900 text-blue-700 dark:text-blue-200' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'"
                        class="w-full flex items-center gap-3 px-4 py-2 text-left transition-colors duration-200">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 18a6 6 0 1 1 0-12 6 6 0 0 1 0 12zM12 2v4m0 8v4M5.64 5.64l2.83 2.83m2 2l2.83 2.83M2 12h4m8 0h4m-11.36 6.36l2.83-2.83m2 2l2.83-2.83" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    </svg>
                    <span class="text-sm font-medium">Clair</span>
                    <svg x-show="currentTheme === 'light'" class="w-4 h-4 ml-auto" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.293 5.293a1 1 0 011.414 1.414l-10 10a1 1 0 01-1.414 0l-5-5a1 1 0 011.414-1.414L10 14.586l9.293-9.293z"/>
                    </svg>
                </button>

                <button @click="selectTheme('dark')"
                        :class="currentTheme === 'dark' ? 'bg-blue-50 dark:bg-blue-900 text-blue-700 dark:text-blue-200' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'"
                        class="w-full flex items-center gap-3 px-4 py-2 text-left transition-colors duration-200">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21.64 15.95a.75.75 0 0 0-.04-1.06A9.75 9.75 0 0 1 9.11 2.4a.75.75 0 0 0-.98.98 8.25 8.25 0 1 0 12.51 12.57.75.75 0 0 0 1 0z" fill="currentColor"/>
                    </svg>
                    <span class="text-sm font-medium">Sombre</span>
                    <svg x-show="currentTheme === 'dark'" class="w-4 h-4 ml-auto" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.293 5.293a1 1 0 011.414 1.414l-10 10a1 1 0 01-1.414 0l-5-5a1 1 0 011.414-1.414L10 14.586l9.293-9.293z"/>
                    </svg>
                </button>

                <button @click="selectTheme('system')"
                        :class="currentTheme === 'system' ? 'bg-blue-50 dark:bg-blue-900 text-blue-700 dark:text-blue-200' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'"
                        class="w-full flex items-center gap-3 px-4 py-2 text-left transition-colors duration-200">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 4.5H7.5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-2M9 4.5h6a2 2 0 0 1 2 2v2M9 4.5V2.25a.75.75 0 0 1 1.5 0v2.25"/>
                    </svg>
                    <span class="text-sm font-medium">Système</span>
                    <svg x-show="currentTheme === 'system'" class="w-4 h-4 ml-auto" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.293 5.293a1 1 0 011.414 1.414l-10 10a1 1 0 01-1.414 0l-5-5a1 1 0 011.414-1.414L10 14.586l9.293-9.293z"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function themeToggle() {
    return {
        isOpen: false,
        currentTheme: 'light',

        init() {
            this.updateCurrentTheme();
            window.addEventListener('theme-changed', (e) => {
                this.updateCurrentTheme();
            });
        },

        updateCurrentTheme() {
            this.currentTheme = window.getStoredTheme?.() || localStorage.getItem('app-theme') || 'system';
        },

        selectTheme(theme) {
            if (window.setTheme) {
                window.setTheme(theme);
            }
            this.isOpen = false;
        }
    }
}
</script>
