<x-layouts::app :title="__('Relatorio de Obras')">
    @php
        $statusBadges = [
            'planning' => ['label' => 'Planejamento', 'class' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200'],
            'in_progress' => ['label' => 'Em andamento', 'class' => 'bg-blue-100 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300'],
            'paused' => ['label' => 'Pausada', 'class' => 'bg-amber-100 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300'],
            'finished' => ['label' => 'Concluida', 'class' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300'],
            'completed' => ['label' => 'Concluida', 'class' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300'],
            'canceled' => ['label' => 'Cancelada', 'class' => 'bg-red-100 text-red-700 dark:bg-red-950/40 dark:text-red-300'],
        ];
    @endphp

    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Relatorio de Obras</h1>
                <p class="page-subtitle">Analise cronograma, status, orcamento e responsaveis das obras com filtros por periodo e operacao.</p>
            </div>
        </div>

        @include('reports.partials.nav')

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            <div class="report-stat-card">
                <p class="report-stat-card__label">Obras encontradas</p>
                <p class="report-stat-card__value">{{ number_format($totals['works'], 0, ',', '.') }}</p>
                <p class="report-stat-card__meta">Resultado atual do filtro aplicado.</p>
            </div>

            <div class="report-stat-card">
                <p class="report-stat-card__label">Orcamento total</p>
                <p class="report-stat-card__value">R$ {{ number_format($totals['budget'], 2, ',', '.') }}</p>
                <p class="report-stat-card__meta">Soma dos valores cadastrados nas obras filtradas.</p>
            </div>

            <div class="report-stat-card">
                <p class="report-stat-card__label">Responsavel em foco</p>
                <p class="report-stat-card__value text-2xl">{{ $filters['responsible'] !== '' ? $filters['responsible'] : 'Todos' }}</p>
                <p class="report-stat-card__meta">{{ $responsibles->count() }} nomes sugeridos para consulta rapida.</p>
            </div>
        </div>

        <div class="panel-card mt-6">
            <div class="panel-card__body">
                <form action="{{ route('reports.works') }}" method="GET" class="space-y-5">
                    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                        <div class="field-group">
                            <label for="status" class="field-label">Status</label>
                            <select name="status" id="status" class="field-input">
                                <option value="">Todos</option>
                                @foreach ($statusOptions as $value => $label)
                                    <option value="{{ $value }}" @selected($filters['status'] === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="field-group">
                            <label for="responsible" class="field-label">Responsavel</label>
                            <input
                                type="text"
                                name="responsible"
                                id="responsible"
                                value="{{ $filters['responsible'] }}"
                                class="field-input"
                                list="work-responsibles"
                                placeholder="Busque por responsavel"
                            >
                            <datalist id="work-responsibles">
                                @foreach ($responsibles as $responsible)
                                    <option value="{{ $responsible }}"></option>
                                @endforeach
                            </datalist>
                        </div>

                        <div class="field-group">
                            <label for="period_from" class="field-label">Inicio do periodo</label>
                            <input type="date" name="period_from" id="period_from" value="{{ $filters['period_from'] }}" class="field-input">
                        </div>

                        <div class="field-group">
                            <label for="period_to" class="field-label">Fim do periodo</label>
                            <input type="date" name="period_to" id="period_to" value="{{ $filters['period_to'] }}" class="field-input">
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 md:flex-row md:justify-end">
                        <a href="{{ route('reports.works') }}" class="ghost-button">Limpar filtros</a>
                        <button type="submit" class="primary-button">Aplicar filtros</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-card mt-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-800">
                    <thead class="bg-zinc-50 dark:bg-zinc-800">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Nome da obra</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Data de inicio</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Previsao de entrega</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Valor total</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Responsavel</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse ($works as $work)
                            @php
                                $status = $statusBadges[$work->status] ?? ['label' => ucfirst(str_replace('_', ' ', $work->status)), 'class' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200'];
                                $responsible = $work->client?->builder?->responsible ?? $work->client?->name ?? '-';
                            @endphp

                            <tr class="report-table-row">
                                <td class="px-6 py-4 text-sm font-semibold text-zinc-800 dark:text-zinc-100">{{ $work->name }}</td>
                                <td class="px-6 py-4 text-sm text-zinc-700 dark:text-zinc-200">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $status['class'] }}">{{ $status['label'] }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">{{ $work->start_date?->format('d/m/Y') ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">{{ $work->expected_end_date?->format('d/m/Y') ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-zinc-800 dark:text-zinc-100">
                                    {{ ! is_null($work->budget) ? 'R$ '.number_format($work->budget, 2, ',', '.') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">{{ $responsible }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-sm text-zinc-500 dark:text-zinc-400">Nenhuma obra encontrada para os filtros informados.</td>
                            </tr>
                        @endforelse
                    </tbody>

                    <tfoot class="bg-zinc-50/80 dark:bg-zinc-900/60">
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-sm font-semibold text-zinc-700 dark:text-zinc-200">Total do periodo filtrado</td>
                            <td class="px-6 py-4 text-sm font-semibold text-zinc-900 dark:text-white">R$ {{ number_format($totals['budget'], 2, ',', '.') }}</td>
                            <td class="px-6 py-4 text-sm text-zinc-500 dark:text-zinc-400">{{ number_format($totals['works'], 0, ',', '.') }} obras</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="border-t border-zinc-100 px-6 py-4 dark:border-zinc-800">
                {{ $works->links() }}
            </div>
        </div>
    </div>
</x-layouts::app>

