@props(['status' => 'draft'])

@php
$config = [
    'draft' => [
        'bg' => 'bg-gray-100',
        'text' => 'text-gray-700',
        'icon' => 'document',
        'label' => 'Brouillon',
    ],
    'submitted' => [
        'bg' => 'bg-blue-100',
        'text' => 'text-blue-700',
        'icon' => 'check',
        'label' => 'Soumis',
    ],
    'in_review' => [
        'bg' => 'bg-amber-100',
        'text' => 'text-amber-700',
        'icon' => 'eye',
        'label' => 'En révision',
    ],
    'changes_requested' => [
        'bg' => 'bg-yellow-100',
        'text' => 'text-yellow-700',
        'icon' => 'pencil',
        'label' => 'Corrections demandées',
    ],
    'approved' => [
        'bg' => 'bg-green-100',
        'text' => 'text-green-700',
        'icon' => 'check-circle',
        'label' => 'Approuvé',
    ],
    'rejected' => [
        'bg' => 'bg-red-100',
        'text' => 'text-red-700',
        'icon' => 'x-circle',
        'label' => 'Rejeté',
    ],
];

$statusConfig = $config[$status] ?? $config['draft'];
@endphp

<span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md text-sm font-medium {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }}">
    <x-icon :name="$statusConfig['icon']" size="sm" class="w-4 h-4" />
    {{ $statusConfig['label'] }}
</span>
