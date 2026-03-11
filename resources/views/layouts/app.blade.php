<x-layouts::app.sidebar :title="$title ?? null">
    <flux:main class="min-h-screen lg:h-screen lg:overflow-y-auto">
        {{ $slot }}
    </flux:main>
</x-layouts::app.sidebar>
