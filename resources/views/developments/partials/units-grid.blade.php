@php
    $statusMap = [
        'available' => [
            'label' => 'Disponível',
            'card' => 'border-emerald-200/80 bg-white hover:border-emerald-300 hover:bg-emerald-50/40 dark:border-emerald-900/40 dark:bg-zinc-900 dark:hover:bg-emerald-950/20',
            'badge' => 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300',
            'dot' => 'bg-green-500',
        ],
        'reserved' => [
            'label' => 'Reservado',
            'card' => 'border-amber-200/80 bg-white hover:border-amber-300 hover:bg-amber-50/40 dark:border-amber-900/40 dark:bg-zinc-900 dark:hover:bg-amber-950/20',
            'badge' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-300',
            'dot' => 'bg-yellow-500',
        ],
        'sold' => [
            'label' => 'Vendido',
            'card' => 'border-red-200/80 bg-white hover:border-red-300 hover:bg-red-50/40 dark:border-red-900/40 dark:bg-zinc-900 dark:hover:bg-red-950/20',
            'badge' => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300',
            'dot' => 'bg-red-500',
        ],
        'blocked' => [
            'label' => 'Bloqueado',
            'card' => 'border-zinc-200 bg-white hover:border-zinc-300 hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 dark:hover:bg-zinc-800',
            'badge' => 'bg-gray-200 text-gray-700 dark:bg-zinc-700 dark:text-zinc-200',
            'dot' => 'bg-zinc-400',
        ],
    ];
@endphp

@if ($units->isEmpty())
    <div class="rounded-3xl border border-dashed border-zinc-300 px-6 py-14 text-center text-sm text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">
        Nenhuma unidade cadastrada para este empreendimento ainda.
    </div>
@else
    <div class="grid grid-cols-2 gap-4 md:grid-cols-4 lg:grid-cols-6">
        @foreach ($units as $unit)
            @php
                $status = $statusMap[$unit->status] ?? $statusMap['blocked'];
            @endphp

            <a
                href="{{ route('units.edit', $unit) }}"
                wire:navigate
                title="Status: {{ $status['label'] }}"
                class="group min-h-[160px] w-full cursor-pointer rounded-2xl border bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-md dark:bg-zinc-900 {{ $status['card'] }}"
            >
                <div class="flex h-full flex-col justify-between gap-5">
                    <div>
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="text-xl font-bold tracking-tight text-zinc-900 dark:text-white">
                                    {{ $unit->identifier }}
                                </h3>
                                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $unit->type }}
                                </p>
                            </div>

                            <span class="mt-1 h-2.5 w-2.5 shrink-0 rounded-full {{ $status['dot'] }}"></span>
                        </div>
                    </div>

                    <div>
                        <p class="text-base font-medium text-zinc-900 dark:text-white">
                            {{ $unit->price ? 'R$ '.number_format((float) $unit->price, 2, ',', '.') : 'Valor não informado' }}
                        </p>

                        <div class="mt-4">
                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $status['badge'] }}">
                                {{ strtoupper($status['label']) }}
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@endif