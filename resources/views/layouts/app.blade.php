<x-layouts::app.sidebar :title="$title ?? null">
    <flux:main>
        <flux:heading size="xl" level="1">{{ $daftar ?? '' }}</flux:heading>
        <flux:separator variant="subtle" />
        {{ $slot }}
    </flux:main>
    
</x-layouts::app.sidebar>
