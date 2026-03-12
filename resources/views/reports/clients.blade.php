<x-layouts::app :title="__('Relatorio de Clientes')">
    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Relatorio de Clientes</h1>
                <p class="page-subtitle">Consulte relacionamento comercial, contatos principais e empreendimentos associados a cada cliente da base.</p>
            </div>
        </div>

        @include('reports.partials.nav')

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            <div class="report-stat-card">
                <p class="report-stat-card__label">Clientes encontrados</p>
                <p class="report-stat-card__value">{{ number_format($totals['total'], 0, ',', '.') }}</p>
                <p class="report-stat-card__meta">Registros retornados pela consulta atual.</p>
            </div>

            <div class="report-stat-card report-stat-card--warning">
                <p class="report-stat-card__label">Leads</p>
                <p class="report-stat-card__value">{{ number_format($totals['leads'], 0, ',', '.') }}</p>
                <p class="report-stat-card__meta">Clientes sem contrato vinculado.</p>
            </div>

            <div class="report-stat-card report-stat-card--success">
                <p class="report-stat-card__label">Clientes ativos</p>
                <p class="report-stat-card__value">{{ number_format($totals['clients'], 0, ',', '.') }}</p>
                <p class="report-stat-card__meta">Clientes com ao menos um contrato.</p>
            </div>
        </div>

        <div class="panel-card mt-6">
            <div class="panel-card__body">
                <form action="{{ route('reports.clients') }}" method="GET" class="space-y-5">
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
                            <label for="development_id" class="field-label">Empreendimento</label>
                            <select name="development_id" id="development_id" class="field-input">
                                <option value="">Todos</option>
                                @foreach ($developments as $development)
                                    <option value="{{ $development->id }}" @selected($filters['development_id'] == (string) $development->id)>{{ $development->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="field-group">
                            <label for="search" class="field-label">Buscar cliente</label>
                            <input
                                type="text"
                                name="search"
                                id="search"
                                value="{{ $filters['search'] }}"
                                class="field-input"
                                placeholder="Nome, email ou telefone"
                            >
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 md:flex-row md:justify-end">
                        <a href="{{ route('reports.clients') }}" class="ghost-button">Limpar filtros</a>
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
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Nome</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Telefone</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Empreendimento</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse ($clients as $client)
                            @php
                                $developmentNames = $client->contracts
                                    ->pluck('development.name')
                                    ->filter()
                                    ->unique()
                                    ->values();

                                $isCustomer = $client->contracts_count > 0;
                            @endphp

                            <tr class="report-table-row">
                                <td class="px-6 py-4 text-sm font-semibold text-zinc-800 dark:text-zinc-100">{{ $client->name }}</td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">{{ $client->phone ?: '-' }}</td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">{{ $client->email ?: '-' }}</td>
                                <td class="px-6 py-4 text-sm text-zinc-700 dark:text-zinc-200">
                                    @if ($developmentNames->isNotEmpty())
                                        <div class="flex flex-wrap gap-2">
                                            @foreach ($developmentNames as $developmentName)
                                                <span class="inline-flex rounded-full bg-zinc-100 px-3 py-1 text-xs font-medium text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200">{{ $developmentName }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-zinc-500 dark:text-zinc-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $isCustomer ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300' : 'bg-amber-100 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300' }}">
                                        {{ $isCustomer ? 'Cliente' : 'Lead' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-sm text-zinc-500 dark:text-zinc-400">Nenhum cliente encontrado para os filtros informados.</td>
                            </tr>
                        @endforelse
                    </tbody>

                    <tfoot class="bg-zinc-50/80 dark:bg-zinc-900/60">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-sm font-semibold text-zinc-700 dark:text-zinc-200">Resumo da consulta</td>
                            <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">{{ number_format($totals['total'], 0, ',', '.') }} clientes</td>
                            <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">{{ number_format($totals['clients'], 0, ',', '.') }} clientes / {{ number_format($totals['leads'], 0, ',', '.') }} leads</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="border-t border-zinc-100 px-6 py-4 dark:border-zinc-800">
                {{ $clients->links() }}
            </div>
        </div>
    </div>
</x-layouts::app>
