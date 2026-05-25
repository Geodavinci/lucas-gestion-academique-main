@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Notifications</h1>
                @if(auth()->user()->notifications()->count() > 0)
                    <button
                        onclick="fetch('{{ route('notifications.deleteAll') }}', {method: 'DELETE'}).then(() => location.reload())"
                        class="text-sm text-red-600 hover:text-red-700 font-medium">
                        Tout supprimer
                    </button>
                @endif
            </div>

            <div class="divide-y divide-gray-200">
                @forelse($notifications as $notification)
                    <div class="p-6 hover:bg-gray-50 transition">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="text-lg font-medium text-gray-900">{{ $notification->title }}</h3>
                                <p class="mt-1 text-gray-600">{{ $notification->message }}</p>
                                <p class="mt-2 text-sm text-gray-500">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <div class="flex items-center gap-2 ml-4">
                                @if($notification->read_at)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        ✓ Lu
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Nouveau
                                    </span>
                                @endif
                                <button
                                    onclick="deleteNotification({{ $notification->id }})"
                                    class="text-gray-400 hover:text-gray-600">
                                    ✕
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-500">
                        <p class="text-lg">Aucune notification</p>
                        <p class="text-sm mt-1">Vous recevrez ici les mises à jour importantes</p>
                    </div>
                @endforelse
            </div>

            @if($notifications->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function deleteNotification(id) {
    if (confirm('Êtes-vous sûr?')) {
        fetch(`/notifications/${id}`, { method: 'DELETE' })
            .then(() => location.reload());
    }
}
</script>
@endsection
