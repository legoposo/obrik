<x-layouts::app :title="__('Empreendimentos')">
    @php
        $statusMap = [
            'planejamento' => ['label' => 'Planejamento', 'class' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200'],
            'lancamento' => ['label' => 'Lancamento', 'class' => 'bg-blue-100 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300'],
            'em_obras' => ['label' => 'Em obras', 'class' => 'bg-amber-100 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300'],
            'finalizado' => ['label' => 'Finalizado', 'class' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300'],
            'entregue' => ['label' => 'Entregue', 'class' => 'bg-violet-100 text-violet-700 dark:bg-violet-950/40 dark:text-violet-300'],
            'cancelado' => ['label' => 'Cancelado', 'class' => 'bg-red-100 text-red-700 dark:bg-red-950/40 dark:text-red-300'],
        ];
    @endphp

    <div class="p-6 space-y-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Empreendimentos</h1>
                <p class="page-subtitle">Cada empreendimento funciona como um hub operacional para unidades, clientes vinculados, reservas, andamento da obra, comunicados e fotos.</p>
            </div>

            <a href="{{ route('developments.create') }}" class="primary-button">Novo empreendimento</a>
        </div>

        @if (session('success'))
            <div class="success-alert">{{ session('success') }}</div>
        @endif

        <div class="panel-card">
            <div class="panel-card__body">
                <div class="panel-card__intro">
                    <p class="panel-card__eyebrow">Busca rapida</p>
                    <h2 class="panel-card__title">Encontre o empreendimento certo</h2>
                    <p class="panel-card__text">Pesquise por nome, localizacao, status ou observacoes para chegar mais rapido ao hub do empreendimento.</p>
                </div>

                <form action="{{ route('developments.index') }}" method="GET" class="space-y-4">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-end">
                        <div class="flex-1 field-group">
                            <label for="search" class="field-label">Buscar empreendimento</label>
                            <input
                                id="search"
                                type="text"
                                name="search"
                                value="{{ $search }}"
                                class="field-input"
                                placeholder="Ex.: Aurora, Centro, em obras"
                            >
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="primary-button">Buscar</button>
                            @if ($search !== '')
                                <a href="{{ route('developments.index') }}" class="ghost-button">Limpar</a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-card">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-800">
                    <thead class="bg-zinc-50 dark:bg-zinc-800">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Empreendimento</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Localizacao</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Lancamento</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Entrega</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Unidades</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Reservas ativas</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500">Acoes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse ($developments as $development)
                            @php
                                $status = $statusMap[$development->status] ?? ['label' => ucfirst(str_replace('_', ' ', $development->status)), 'class' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200'];
                            @endphp

                            <tr class="report-table-row align-top">
                                <td class="px-6 py-4 text-sm text-zinc-700 dark:text-zinc-200">
                                    <a href="{{ route('developments.show', $development) }}" class="font-semibold text-zinc-900 hover:text-blue-600 dark:text-white">
                                        {{ $development->name }}
                                    </a>
                                    @if ($development->description)
                                        <p class="mt-2 max-w-sm text-xs leading-5 text-zinc-500 dark:text-zinc-400">{{ \Illuminate\Support\Str::limit($development->description, 96) }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">{{ $development->location ?: '-' }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $status['class'] }}">{{ $status['label'] }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">{{ $development->launch_date?->format('d/m/Y') ?? $development->start_date?->format('d/m/Y') ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">{{ $development->expected_delivery?->format('d/m/Y') ?? $development->expected_delivery_date?->format('d/m/Y') ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">{{ number_format($development->units_count, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">{{ number_format($development->active_contracts_count, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('developments.show', $development) }}" class="action-icon border-emerald-200 bg-emerald-50 text-emerald-600 hover:border-emerald-300 hover:bg-emerald-100 hover:text-emerald-700 focus:ring-emerald-500/20 dark:border-emerald-900/60 dark:bg-emerald-950/40 dark:text-emerald-300 dark:hover:bg-emerald-900/40" title="Abrir hub do empreendimento">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 18.75V6.75A2.25 2.25 0 0 1 6.75 4.5h10.5A2.25 2.25 0 0 1 19.5 6.75v12M8.25 9.75h7.5m-7.5 3h7.5m-7.5 3h4.5" />
                                            </svg>
                                        </a>

                                        <a href="{{ route('units.index', ['development_id' => $development->id]) }}" class="action-icon action-icon--timeline" title="Ver unidades">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.5h16.5v15H3.75z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5v15m7.5-15v15M3.75 9.75h16.5M3.75 14.25h16.5" />
                                            </svg>
                                        </a>

                                        <a href="{{ route('developments.edit', $development) }}" class="action-icon action-icon--edit" title="Editar empreendimento">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487a2.1 2.1 0 1 1 2.97 2.97L8.25 19.04 4 20l.96-4.25 11.902-11.263Z" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('developments.destroy', $development) }}" method="POST" onsubmit="return confirm('Deseja realmente excluir este empreendimento?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="action-icon action-icon--delete" title="Excluir empreendimento">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12M9 7V5.75A1.75 1.75 0 0 1 10.75 4h2.5A1.75 1.75 0 0 1 15 5.75V7m-7 0 1 11.25A1.75 1.75 0 0 0 10.74 20h2.52A1.75 1.75 0 0 0 15 18.25L16 7" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-10 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $search !== '' ? 'Nenhum empreendimento encontrado para os filtros informados.' : 'Nenhum empreendimento cadastrado ainda.' }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-zinc-100 px-6 py-4 dark:border-zinc-800">
                {{ $developments->links() }}
            </div>
        </div>
    </div>
</x-layouts::app>