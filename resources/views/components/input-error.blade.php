@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1 mt-1.5']) }}>
        @foreach ((array) $messages as $message)
            <li class="flex items-center gap-2">
                <span class="w-1 h-1 bg-red-600 rounded-full"></span>
                {{ $message }}
            </li>
        @endforeach
    </ul>
@endif
