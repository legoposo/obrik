@php
    $statusStyles = [
        'available' => [
            'cell' => 'border-emerald-200 bg-emerald-50 text-emerald-700 hover:border-emerald-300 dark:border-emerald-900/60 dark:bg-emerald-950/30 dark:text-emerald-300',
            'dot' => 'bg-emerald-500',
            'label' => 'Disponível',
        ],
        'reserved' => [
            'cell' => 'border-amber-200 bg-amber-50 text-amber-700 hover:border-amber-300 dark:border-amber-900/60 dark:bg-amber-950/30 dark:text-amber-300',
            'dot' => 'bg-amber-500',
            'label' => 'Reservado',
        ],
        'sold' => [
            'cell' => 'border-red-200 bg-red-50 text-red-700 hover:border-red-300 dark:border-red-900/60 dark:bg-red-950/30 dark:text-red-300',
            'dot' => 'bg-red-500',
            'label' => 'Vendido',
        ],
        'blocked' => [
            'cell' => 'border-zinc-300 bg-zinc-100 text-zinc-700 hover:border-zinc-400 dark:border-zinc-700 dark:bg-zinc-800/70 dark:text-zinc-200',
            'dot' => 'bg-zinc-400',
            'label' => 'Bloqueado',
        ],
    ];

    $unitsWithFloor = $units
        ->filter(fn ($unit) => filled($unit->floor))
        ->groupBy('floor')
        ->sortKeysDesc();

    $unitsWithoutFloor = $units->filter(fn ($unit) => blank($unit->floor));
@endphp

@if ($units->isEmpty())
    <div class="rounded-2xl border border-dashed border-zinc-300 bg-zinc-50 px-6 py-12 text-center dark:border-zinc-700 dark:bg-zinc-900/40">
        <p class="text-sm text-zinc-500 dark:text-zinc-400">Nenhuma unidade cadastrada para este empreendimento.</p>
    </div>
@else
    <div class="space-y-6">
        <div class="flex flex-wrap gap-3">
            <div class="inline-flex items-center gap-2 rounded-full border border-zinc-200 bg-white px-3 py-1.5 text-xs font-medium text-zinc-700 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200">
                <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                Disponível
            </div>

            <div class="inline-flex items-center gap-2 rounded-full border border-zinc-200 bg-white px-3 py-1.5 text-xs font-medium text-zinc-700 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200">
                <span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span>
                Reservado
            </div>

            <div class="inline-flex items-center gap-2 rounded-full border border-zinc-200 bg-white px-3 py-1.5 text-xs font-medium text-zinc-700 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200">
                <span class="h-2.5 w-2.5 rounded-full bg-red-500"></span>
                Vendido
            </div>

            <div class="inline-flex items-center gap-2 rounded-full border border-zinc-200 bg-white px-3 py-1.5 text-xs font-medium text-zinc-700 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200">
                <span class="h-2.5 w-2.5 rounded-full bg-zinc-400"></span>
                Bloqueado
            </div>
        </div>

        @foreach ($unitsWithFloor as $floor => $floorUnits)
            <div class="rounded-2xl border border-zinc-200 bg-white p-4 dark:border-zinc-800 dark:bg-zinc-900/60">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">
                            Andar {{ $floor }}
                        </h3>
                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $floorUnits->count() }} unidade(s)
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 xl:grid-cols-10 2xl:grid-cols-12">
                    @foreach ($floorUnits->sortBy('name') as $unit)
                        @php
                            $style = $statusStyles[$unit->status] ?? $statusStyles['blocked'];
                        @endphp

                        <a
                            href="{{ route('units.edit', $unit) }}"
                            wire:navigate
                            x-show="statusFilter === 'all' || statusFilter === '{{ $unit->status }}'"
                            x-transition.opacity.scale.95
                            class="group flex min-h-[84px] flex-col items-center justify-center rounded-xl border px-3 py-3 text-center shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md {{ $style['cell'] }}"
                            title="{{ $unit->name }} • {{ ucfirst($unit->type) }} • {{ $style['label'] }}{{ $unit->price ? ' • R$ ' . number_format($unit->price, 2, ',', '.') : '' }}"
                        >
                            <div class="mb-2 flex items-center gap-1.5">
                                <span class="h-2.5 w-2.5 rounded-full {{ $style['dot'] }}"></span>
                            </div>

                            <span class="text-base font-bold leading-none">
                                {{ $unit->name }}
                            </span>

                            @if ($unit->price)
                                <span class="mt-1 text-[10px] font-medium opacity-75">
                                    {{ 'R$ ' . number_format($unit->price, 0, ',', '.') }}
                                </span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach

        @if ($unitsWithoutFloor->isNotEmpty())
            <div class="rounded-2xl border border-dashed border-zinc-300 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-900/40">
                <div class="mb-4">
                    <h3 class="text-sm font-bold uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">
                        Sem andar definido
                    </h3>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                        {{ $unitsWithoutFloor->count() }} unidade(s)
                    </p>
                </div>

                <div class="grid grid-cols-3 gap-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 xl:grid-cols-10 2xl:grid-cols-12">
                    @foreach ($unitsWithoutFloor->sortBy('name') as $unit)
                        @php
                            $style = $statusStyles[$unit->status] ?? $statusStyles['blocked'];
                        @endphp

                        <a
                            href="{{ route('units.edit', $unit) }}"
                            wire:navigate
                            x-show="statusFilter === 'all' || statusFilter === '{{ $unit->status }}'"
                            x-transition.opacity.scale.95
                            class="group flex min-h-[84px] flex-col items-center justify-center rounded-xl border px-3 py-3 text-center shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md {{ $style['cell'] }}"
                            title="{{ $unit->name }} • {{ ucfirst($unit->type) }} • {{ $style['label'] }}{{ $unit->price ? ' • R$ ' . number_format($unit->price, 2, ',', '.') : '' }}"
                        >
                            <div class="mb-2 flex items-center gap-1.5">
                                <span class="h-2.5 w-2.5 rounded-full {{ $style['dot'] }}"></span>
                            </div>

                            <span class="text-base font-bold leading-none">
                                {{ $unit->name }}
                            </span>

                            @if ($unit->price)
                                <span class="mt-1 text-[10px] font-medium opacity-75">
                                    {{ 'R$ ' . number_format($unit->price, 0, ',', '.') }}
                                </span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endif