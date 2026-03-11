@php
    $statusMap = [
        'available' => [
            'label' => 'Disponível',
            'card' => 'border-green-200 bg-green-50 text-green-900 hover:border-green-300 hover:bg-green-100/70 dark:border-green-900/40 dark:bg-green-950/20 dark:text-green-100 dark:hover:bg-green-950/35',
        ],
        'reserved' => [
            'label' => 'Reservado',
            'card' => 'border-yellow-200 bg-yellow-50 text-yellow-900 hover:border-yellow-300 hover:bg-yellow-100/70 dark:border-yellow-900/40 dark:bg-yellow-950/20 dark:text-yellow-100 dark:hover:bg-yellow-950/35',
        ],
        'sold' => [
            'label' => 'Vendido',
            'card' => 'border-red-200 bg-red-50 text-red-900 hover:border-red-300 hover:bg-red-100/70 dark:border-red-900/40 dark:bg-red-950/20 dark:text-red-100 dark:hover:bg-red-950/35',
        ],
        'blocked' => [
            'label' => 'Bloqueado',
            'card' => 'border-gray-300 bg-gray-100 text-gray-700 hover:border-gray-400 hover:bg-gray-200/80 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100 dark:hover:bg-zinc-700',
        ],
    ];
@endphp

@if ($units->isEmpty())
    <div class="rounded-3xl border border-dashed border-zinc-300 px-6 py-14 text-center text-sm text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">
        Nenhuma unidade cadastrada para este empreendimento ainda.
    </div>
@else
    <div class="grid grid-cols-4 gap-3 sm:grid-cols-6 md:grid-cols-8 lg:grid-cols-10 xl:grid-cols-12">
        @foreach ($units as $unit)
            @php
                $status = $statusMap[$unit->status] ?? $statusMap['blocked'];
                $statusKey = $unit->status;
            @endphp

            <a
                href="{{ route('units.edit', $unit) }}"
                wire:navigate
                x-show="statusFilter === 'all' || statusFilter === '{{ $statusKey }}'"
                title="{{ $unit->identifier }} | {{ $status['label'] }}"
                class="flex min-h-[60px] cursor-pointer items-center justify-center rounded-xl border px-2 py-2 text-center text-sm font-bold shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md {{ $status['card'] }}"
            >
                <span class="leading-tight">{{ $unit->identifier }}</span>
            </a>
        @endforeach
    </div>
@endif