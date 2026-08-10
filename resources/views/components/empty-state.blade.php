@props([
    'title' => null,
    'description' => null,
])

<div {{ $attributes->class('flex min-h-40 flex-col items-center justify-center px-6 py-10 text-center') }}>
    <p class="text-sm font-semibold text-slate-800">{{ $title ?: __('ui::ui.empty') }}</p>

    @if ($description)
        <p class="mt-1 max-w-md text-sm text-slate-500">{{ $description }}</p>
    @endif

    @if ($slot->isNotEmpty())
        <div class="mt-4">
            {{ $slot }}
        </div>
    @endif
</div>
