@props(['rows' => 5, 'columns' => 6])

<div class="w-full animate-pulse">
    @for ($i = 0; $i < $rows; $i++)
        <div class="border-b border-gray-200">
            <div class="flex items-center gap-4 px-4 py-3 h-16">
                @for ($j = 0; $j < $columns; $j++)
                    <div class="flex-1">
                        @if ($j === 0)
                            <div class="h-4 w-16 bg-gray-300 rounded"></div>
                        @elseif ($j === $columns - 1)
                            <div class="space-y-2">
                                <div class="h-3 w-8 bg-gray-300 rounded"></div>
                                <div class="h-3 w-8 bg-gray-300 rounded"></div>
                            </div>
                        @else
                            <div class="space-y-2">
                                <div class="h-3 w-full bg-gray-300 rounded"></div>
                                <div class="h-3 w-2/3 bg-gray-300 rounded"></div>
                            </div>
                        @endif
                    </div>
                @endfor
            </div>
        </div>
    @endfor
</div>

<style>
    @keyframes shimmer {
        0% {
            background-position: -1000px 0;
        }
        100% {
            background-position: 1000px 0;
        }
    }

    .animate-pulse > div .bg-gray-300 {
        background: linear-gradient(
            90deg,
            rgba(209, 213, 219, 0.5) 0%,
            rgba(229, 231, 235, 0.8) 50%,
            rgba(209, 213, 219, 0.5) 100%
        );
        background-size: 200% 100%;
        animation: shimmer 2s infinite;
    }
</style>
