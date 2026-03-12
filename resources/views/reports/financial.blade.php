<x-layouts::app :title="__('Relatorio Financeiro')">
    @php
        $typeBadges = [
            'income' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300',
            'expense' => 'bg-red-100 text-red-700 dark:bg-red-950/40 dark:text-red-300',
        ];

        $statusBadges = [
            'pending' => 'bg-amber-100 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300',
            'paid' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300',
            'overdue' => 'bg-red-100 text-red-700 dark:bg-red-950/40 dark:text-red-300',
        ];
    @endphp

    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Relatorio Financeiro</h1>
                <p class="page-subtitle">Monitore receitas, despesas e saldo com leitura rapida por obra, tipo e periodo financeiro.</p>
            </div>
        </div>

        @include('reports.partials.nav')

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            <div class="report-stat-card report-stat-card--success">
                <p class="report-stat-card__label">Total de receitas</p>
                <p class="report-stat-card__value">R$ {{ number_format($totals['income'], 2, ',', '.') }}</p>
                <p class="report-stat-card__meta">Entradas consideradas no filtro atual.</p>
            </div>

            <div class="report-stat-card report-stat-card--danger">
                <p class="report-stat-card__label">Total de despesas</p>
                <p class="report-stat-card__value">R$ {{ number_format($totals['expense'], 2, ',', '.') }}</p>
                <p class="report-stat-card__meta">Saidas apuradas no periodo selecionado.</p>
            </div>

            <div class="report-stat-card report-stat-card--info">
                <p class="report-stat-card__label">Saldo</p>
                <p class="report-stat-card__value">R$ {{ number_format($totals['balance'], 2, ',', '.') }}</p>
                <p class="report-stat-card__meta">Receitas menos despesas dentro da consulta.</p>
            </div>
        </div>

        <div class="panel-card mt-6">
            <div class="panel-card__body">
                <form action="{{ route('reports.financial') }}" method="GET" class="space-y-5">
                    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
                        <div class="field-group">
                            <label for="type" class="field-label">Tipo</label>
                            <select name="type" id="type" class="field-input">
                                <option value="">Todos</option>
                                @foreach ($typeOptions as $value => $label)
                                    <option value="{{ $value }}" @selected($filters['type'] === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

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
                            <label for="work_id" class="field-label">Obra</label>
                            <select name="work_id" id="work_id" class="field-input">
                                <option value="">Todas</option>
                                @foreach ($works as $work)
                                    <option value="{{ $work->id }}" @selected($filters['work_id'] == (string) $work->id)>{{ $work->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="field-group">
                            <label for="period_from" class="field-label">Periodo inicial</label>
                            <input type="date" name="period_from" id="period_from" value="{{ $filters['period_from'] }}" class="field-input">
                        </div>

                        <div class="field-group">
                            <label for="period_to" class="field-label">Periodo final</label>
                            <input type="date" name="period_to" id="period_to" value="{{ $filters['period_to'] }}" class="field-input">
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 md:flex-row md:justify-end">
                        <a href="{{ route('reports.financial') }}" class="ghost-button">Limpar filtros</a>
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
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Data</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Tipo</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Categoria</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Obra</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Valor</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse ($entries as $entry)
                            <tr class="report-table-row">
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">
                                    {{ $entry->paid_at?->format('d/m/Y') ?? $entry->due_date?->format('d/m/Y') ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-700 dark:text-zinc-200">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $typeBadges[$entry->type] ?? 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200' }}">
                                        {{ $typeOptions[$entry->type] ?? ucfirst($entry->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-700 dark:text-zinc-200">
                                    <div class="font-semibold text-zinc-800 dark:text-zinc-100">{{ $entry->category ?: 'Sem categoria' }}</div>
                                    <div class="mt-1 flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400">
                                        <span>{{ $entry->description }}</span>
                                        <span class="inline-flex rounded-full px-2.5 py-1 font-semibold {{ $statusBadges[$entry->status] ?? 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200' }}">
                                            {{ $statusOptions[$entry->status] ?? ucfirst($entry->status) }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-700 dark:text-zinc-200">{{ $entry->work->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-zinc-900 dark:text-white">R$ {{ number_format($entry->amount, 2, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-sm text-zinc-500 dark:text-zinc-400">Nenhum lancamento encontrado para os filtros informados.</td>
                            </tr>
                        @endforelse
                    </tbody>

                    <tfoot class="bg-zinc-50/80 dark:bg-zinc-900/60">
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">
                                <span class="font-semibold text-zinc-800 dark:text-zinc-100">Totais do filtro:</span>
                                Receitas R$ {{ number_format($totals['income'], 2, ',', '.') }}
                                | Despesas R$ {{ number_format($totals['expense'], 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-zinc-900 dark:text-white">R$ {{ number_format($totals['balance'], 2, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="border-t border-zinc-100 px-6 py-4 dark:border-zinc-800">
                {{ $entries->links() }}
            </div>
        </div>
    </div>
</x-layouts::app>
