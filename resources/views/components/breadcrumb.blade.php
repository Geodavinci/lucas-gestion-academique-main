<!-- Breadcrumb Navigation -->
<nav class="flex items-center gap-2 text-sm mb-6">
    <!-- Home -->
    <a href="{{ route('dashboard') }}" class="flex items-center gap-1.5 text-gray-600 hover:text-gray-900 transition-colors">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
        </svg>
        <span>Accueil</span>
    </a>

    <!-- Items -->
    @foreach ($items as $item)
        <!-- Separator -->
        <span class="text-gray-400">/</span>

        <!-- Item -->
        @if (isset($item['url']) && $item['url'])
            <a href="{{ $item['url'] }}" class="text-gray-600 hover:text-gray-900 transition-colors">
                {{ $item['label'] }}
            </a>
        @else
            <span class="text-gray-900 font-medium">{{ $item['label'] }}</span>
        @endif
    @endforeach
</nav>
