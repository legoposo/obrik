<x-layouts::app :title="__('Relatorio de Empreendimentos')">
    @php
        $statusBadges = [
            'planning' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200',
            'in_progress' => 'bg-blue-100 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300',
            'paused' => 'bg-amber-100 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300',
            'completed' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300',
            'canceled' => 'bg-red-100 text-red-700 dark:bg-red-950/40 dark:text-red-300',
        ];
    @endphp

    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Relatorio de Empreendimentos</h1>
                <p class="page-subtitle">Visualize performance de estoque, andamento e distribuicao de unidades por empreendimento.</p>
            </div>
        </div>

        @include('reports.partials.nav')

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            <div class="report-stat-card">
                <p class="report-stat-card__label">Empreendimentos encontrados</p>
                <p class="report-stat-card__value">{{ number_format($totals['developments'], 0, ',', '.') }}</p>
                <p class="report-stat-card__meta">Volume de projetos dentro do filtro.</p>
            </div>

            <div class="report-stat-card report-stat-card--info">
                <p class="report-stat-card__label">Numero de unidades</p>
                <p class="report-stat-card__value">{{ number_format($totals['units'], 0, ',', '.') }}</p>
                <p class="report-stat-card__meta">Total agregado de unidades cadastradas.</p>
            </div>

            <div class="report-stat-card report-stat-card--success">
                <p class="report-stat-card__label">Unidades disponiveis</p>
                <p class="report-stat-card__value">{{ number_format($totals['available_units'], 0, ',', '.') }}</p>
                <p class="report-stat-card__meta">Estoque livre para comercializacao.</p>
            </div>
        </div>

        <div class="panel-card mt-6">
            <div class="panel-card__body">
                <form action="{{ route('reports.developments') }}" method="GET" class="space-y-5">
                    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
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
                            <label for="builder_id" class="field-label">Construtora</label>
                            <select name="builder_id" id="builder_id" class="field-input">
                                <option value="">Todas</option>
                                @foreach ($builders as $builder)
                                    <option value="{{ $builder->id }}" @selected($filters['builder_id'] == (string) $builder->id)>{{ $builder->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="field-group">
                            <label for="search" class="field-label">Buscar</label>
                            <input
                                type="text"
                                name="search"
                                id="search"
                                value="{{ $filters['search'] }}"
                                class="field-input"
                                placeholder="Nome, cidade ou construtora"
                            >
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 md:flex-row md:justify-end">
                        <a href="{{ route('reports.developments') }}" class="ghost-button">Limpar filtros</a>
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
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Nome do empreendimento</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Construtora</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Numero de unidades</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Unidades disponiveis</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse ($developments as $development)
                            <tr class="report-table-row">
                                <td class="px-6 py-4 text-sm font-semibold text-zinc-800 dark:text-zinc-100">{{ $development->name }}</td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">{{ $development->builder->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusBadges[$development->status] ?? 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200' }}">
                                        {{ $statusOptions[$development->status] ?? ucfirst(str_replace('_', ' ', $development->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-700 dark:text-zinc-200">{{ number_format($development->units_count, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-zinc-900 dark:text-white">{{ number_format($development->available_units_count, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-sm text-zinc-500 dark:text-zinc-400">Nenhum empreendimento encontrado para os filtros informados.</td>
                            </tr>
                        @endforelse
                    </tbody>

                    <tfoot class="bg-zinc-50/80 dark:bg-zinc-900/60">
                        <tr>
                            <td colspan="2" class="px-6 py-4 text-sm font-semibold text-zinc-700 dark:text-zinc-200">Totais consolidados</td>
                            <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">{{ number_format($totals['developments'], 0, ',', '.') }} empreendimentos</td>
                            <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">{{ number_format($totals['units'], 0, ',', '.') }} unidades</td>
                            <td class="px-6 py-4 text-sm font-semibold text-zinc-900 dark:text-white">{{ number_format($totals['available_units'], 0, ',', '.') }} disponiveis</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="border-t border-zinc-100 px-6 py-4 dark:border-zinc-800">
                {{ $developments->links() }}
            </div>
        </div>
    </div>
</x-layouts::app>
