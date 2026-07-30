@props([
    'status',
    'size' => null,
])

<flux:badge :color="$status->color()" :icon="$status->icon()" :size="$size" {{ $attributes }}>
    {{ $status->label() }}
</flux:badge>
