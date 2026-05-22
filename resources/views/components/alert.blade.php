@props([
    'type' => 'info',
    'title' => null,
    'message' => null,
    'closeable' => true,
    'id' => null,
])

@php
$config = [
    'info' => [
        'bg' => 'bg-blue-50',
        'border' => 'border-blue-200',
        'icon' => 'alert-circle',
        'text' => 'text-blue-800',
        'title-text' => 'text-blue-900',
    ],
    'success' => [
        'bg' => 'bg-green-50',
        'border' => 'border-green-200',
        'icon' => 'check-circle',
        'text' => 'text-green-800',
        'title-text' => 'text-green-900',
    ],
    'warning' => [
        'bg' => 'bg-amber-50',
        'border' => 'border-amber-200',
        'icon' => 'alert-circle',
        'text' => 'text-amber-800',
        'title-text' => 'text-amber-900',
    ],
    'danger' => [
        'bg' => 'bg-red-50',
        'border' => 'border-red-200',
        'icon' => 'x-circle',
        'text' => 'text-red-800',
        'title-text' => 'text-red-900',
    ],
];

$alertConfig = $config[$type] ?? $config['info'];
@endphp

<div {{ $attributes->merge(['class' => $alertConfig['bg'] . ' border ' . $alertConfig['border'] . ' rounded-lg p-4']) }} {{ $id ? 'id=' . $id : '' }}>
    <div class="flex gap-3">
        <x-icon :name="$alertConfig['icon']" size="md" :class="$alertConfig['text']" />

        <div class="flex-1">
            @if($title)
                <h3 class="font-semibold {{ $alertConfig['title-text'] }} mb-1">
                    {{ $title }}
                </h3>
            @endif

            @if($message)
                <p class="{{ $alertConfig['text'] }} text-sm">
                    {{ $message }}
                </p>
            @else
                <div class="{{ $alertConfig['text'] }} text-sm">
                    {{ $slot }}
                </div>
            @endif
        </div>

        @if($closeable)
            <button
                type="button"
                onclick="this.parentElement.style.display='none'"
                class="{{ $alertConfig['text'] }} hover:opacity-70 transition-opacity"
                aria-label="Close alert"
            >
                <x-icon name="x" size="md" />
            </button>
        @endif
    </div>
</div>
