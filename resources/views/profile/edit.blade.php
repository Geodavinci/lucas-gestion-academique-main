<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <x-icon name="user" size="md" class="w-6 h-6 text-gray-600" />
            <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                {{ __('Mon Profil') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Profile Information Section -->
            <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
                <div class="px-8 py-6 bg-gradient-to-r from-gray-50 to-gray-100 border-b-2 border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <x-icon name="user-check" size="md" class="w-5 h-5 text-gray-600" />
                        Informations du profil
                    </h3>
                </div>
                <div class="p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <!-- Password Section -->
            <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
                <div class="px-8 py-6 bg-gradient-to-r from-gray-50 to-gray-100 border-b-2 border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <x-icon name="lock" size="md" class="w-5 h-5 text-gray-600" />
                        Mot de passe
                    </h3>
                </div>
                <div class="p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <!-- Delete Account Section -->
            <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
                <div class="px-8 py-6 bg-gradient-to-r from-red-50 to-red-100 border-b-2 border-red-200">
                    <h3 class="text-lg font-bold text-red-900 flex items-center gap-2">
                        <x-icon name="trash-2" size="md" class="w-5 h-5 text-red-600" />
                        Supprimer le compte
                    </h3>
                </div>
                <div class="p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
