<x-layouts::app.sidebar :title="$title ?? null">
    <flux:main>
        @if (!request()->routeIs('dashboard'))
            <flux:heading size="xl" level="1">{{ $daftar ?? '' }}</flux:heading>
            <flux:separator variant="subtle" />
        @endif
        {{ $slot }}
    </flux:main>
    
</x-layouts::app.sidebar>
