<section {{ $attributes->class('min-w-0 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm') }}>
    @isset($header)
        <header class="border-b border-slate-200 px-4 py-3 sm:px-5">
            {{ $header }}
        </header>
    @endisset

    <div class="p-4 sm:p-5">
        {{ $slot }}
    </div>

    @isset($footer)
        <footer class="border-t border-slate-200 bg-slate-50 px-4 py-3 sm:px-5">
            {{ $footer }}
        </footer>
    @endisset
</section>
