@props([
    'name' => null,
    'label' => null,
    'value' => '1',
    'checked' => false,
    'error' => null,
])

@php
    $id = $attributes->get('id') ?? ($name ? 'ui-'.str_replace(['[', ']', '.'], '-', $name) : null);
    $errorMessage = $error ?? ($name && isset($errors) ? $errors->first($name) : null);
@endphp

<div class="min-w-0">
    <label class="inline-flex items-start gap-2 text-sm text-slate-700">
        <input
            type="checkbox"
            @if ($id) id="{{ $id }}" @endif
            @if ($name) name="{{ $name }}" @endif
            value="{{ $value }}"
            @checked($checked)
            {{ $attributes->except('id')->class('mt-0.5 size-4 rounded border-slate-300 text-slate-900 focus:ring-slate-400') }}
        >

        @if ($label)
            <span>{{ $label }}</span>
        @endif
    </label>

    @if ($errorMessage)
        <p class="mt-1.5 text-xs text-red-600">{{ $errorMessage }}</p>
    @endif
</div>
