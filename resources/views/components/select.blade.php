@props([
    'name' => null,
    'label' => null,
    'error' => null,
    'hint' => null,
])

@php
    $id = $attributes->get('id') ?? ($name ? 'ui-'.str_replace(['[', ']', '.'], '-', $name) : null);
    $errorMessage = $error ?? ($name && isset($errors) ? $errors->first($name) : null);
@endphp

<div class="min-w-0">
    @if ($label)
        <label @if ($id) for="{{ $id }}" @endif class="mb-1.5 block text-sm font-medium text-slate-700">
            {{ $label }}
        </label>
    @endif

    <select
        @if ($id) id="{{ $id }}" @endif
        @if ($name) name="{{ $name }}" @endif
        {{ $attributes->except('id')->class([
            'block w-full rounded-lg border bg-white px-3 py-2 text-sm text-slate-900 shadow-sm outline-none transition focus:ring-2 disabled:cursor-not-allowed disabled:bg-slate-100 disabled:text-slate-500',
            'border-red-300 focus:border-red-500 focus:ring-red-100' => filled($errorMessage),
            'border-slate-300 focus:border-slate-500 focus:ring-slate-100' => blank($errorMessage),
        ]) }}
    >
        {{ $slot }}
    </select>

    @if ($errorMessage)
        <p class="mt-1.5 text-xs text-red-600">{{ $errorMessage }}</p>
    @elseif ($hint)
        <p class="mt-1.5 text-xs text-slate-500">{{ $hint }}</p>
    @endif
</div>
