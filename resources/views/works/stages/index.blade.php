<x-layouts::app :title="__('Cronograma da Obra')">
    @php
        $statusMap = [
            'pending' => ['label' => 'Pendente', 'class' => 'bg-amber-100 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300'],
            'in_progress' => ['label' => 'Em andamento', 'class' => 'bg-blue-100 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300'],
            'completed' => ['label' => 'Concluido', 'class' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300'],
        ];
    @endphp

    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Cronograma da Obra</h1>
                <p class="page-subtitle">Acompanhe o andamento de cada etapa da obra com progresso visual, datas-chave e responsaveis definidos.</p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('works.index') }}" class="ghost-button">Voltar para obras</a>
                <a href="{{ route('works.stages.create', $work) }}" class="primary-button">Adicionar Etapa</a>
            </div>
        </div>

        @if (session('success'))
            <div class="success-alert">{{ session('success') }}</div>
        @endif

        <div class="panel-card mb-6">
            <div class="panel-card__body">
                <div class="grid gap-6 xl:grid-cols-[minmax(0,1.4fr)_minmax(320px,0.8fr)] xl:items-start">
                    <div class="panel-card__intro mb-0">
                        <p class="panel-card__eyebrow">Obra em acompanhamento</p>
                        <h2 class="panel-card__title">{{ $work->name }}</h2>
                        <p class="panel-card__text">Cliente: {{ $work->client->name ?? '-' }}. Inicio da obra: {{ $work->start_date?->format('d/m/Y') ?? '-' }}. Previsao de entrega: {{ $work->expected_end_date?->format('d/m/Y') ?? '-' }}.</p>

                        <div class="mt-6 grid gap-3 md:grid-cols-3">
                            <div class="rounded-2xl border border-zinc-200 bg-white px-4 py-4 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">Status da obra</p>
                                <p class="mt-2 text-sm font-semibold text-zinc-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $work->status)) }}</p>
                            </div>

                            <div class="rounded-2xl border border-zinc-200 bg-white px-4 py-4 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">Orcamento</p>
                                <p class="mt-2 text-sm font-semibold text-zinc-900 dark:text-white">{{ ! is_null($work->budget) ? 'R$ '.number_format($work->budget, 2, ',', '.') : '-' }}</p>
                            </div>

                            <div class="rounded-2xl border border-zinc-200 bg-white px-4 py-4 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">Etapas cadastradas</p>
                                <p class="mt-2 text-sm font-semibold text-zinc-900 dark:text-white">{{ number_format($progress['total'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-zinc-200/80 bg-white p-6 shadow-sm shadow-zinc-200/50 dark:border-zinc-800 dark:bg-zinc-900 dark:shadow-none">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-blue-600 dark:text-blue-300">Progresso geral</p>
                        <p class="mt-3 text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ $progress['percentage'] }}%</p>
                        <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ $progress['percentage'] }}% da obra concluida</p>

                        <div class="mt-4 h-3 overflow-hidden rounded-full bg-zinc-200 dark:bg-zinc-800">
                            <div class="h-full rounded-full bg-blue-600 transition-all duration-500" style="width: {{ $progress['percentage'] }}%"></div>
                        </div>

                        <div class="mt-4 flex items-center justify-between text-sm text-zinc-500 dark:text-zinc-400">
                            <span>{{ number_format($progress['completed'], 0, ',', '.') }} concluidas</span>
                            <span>{{ number_format($progress['total'], 0, ',', '.') }} etapas no total</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <div class="report-stat-card">
                <p class="report-stat-card__label">Pendentes</p>
                <p class="report-stat-card__value">{{ number_format($progress['pending'], 0, ',', '.') }}</p>
                <p class="report-stat-card__meta">Etapas ainda nao iniciadas.</p>
            </div>

            <div class="report-stat-card report-stat-card--info">
                <p class="report-stat-card__label">Em andamento</p>
                <p class="report-stat-card__value">{{ number_format($progress['in_progress'], 0, ',', '.') }}</p>
                <p class="report-stat-card__meta">Etapas em execucao neste momento.</p>
            </div>

            <div class="report-stat-card report-stat-card--success">
                <p class="report-stat-card__label">Concluidas</p>
                <p class="report-stat-card__value">{{ number_format($progress['completed'], 0, ',', '.') }}</p>
                <p class="report-stat-card__meta">Etapas finalizadas e contabilizadas no progresso.</p>
            </div>
        </div>

        <div class="table-card mt-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-800">
                    <thead class="bg-zinc-50 dark:bg-zinc-800">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Etapa</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Inicio</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Previsao</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Conclusao</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Responsavel</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500">Acoes</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse ($stages as $stage)
                            @php
                                $status = $statusMap[$stage->status] ?? ['label' => ucfirst(str_replace('_', ' ', $stage->status)), 'class' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200'];
                            @endphp

                            <tr class="report-table-row align-top">
                                <td class="px-6 py-4 text-sm font-semibold text-zinc-800 dark:text-zinc-100">
                                    {{ $stage->name }}
                                    @if ($stage->notes)
                                        <p class="mt-2 max-w-xs text-xs font-normal leading-5 text-zinc-500 dark:text-zinc-400">{{ $stage->notes }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-700 dark:text-zinc-200">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $status['class'] }}">{{ $status['label'] }}</span>

                                    <form action="{{ route('works.stages.status', [$work, $stage]) }}" method="POST" class="mt-3 flex flex-col gap-2 sm:flex-row sm:items-center">
                                        @csrf
                                        @method('PATCH')

                                        <select name="status" class="rounded-xl border border-zinc-200 bg-white px-3 py-2 text-xs font-medium text-zinc-700 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200">
                                            @foreach ($statusOptions as $value => $label)
                                                <option value="{{ $value }}" @selected($stage->status === $value)>{{ $label }}</option>
                                            @endforeach
                                        </select>

                                        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-zinc-100 px-3 py-2 text-xs font-semibold text-zinc-700 transition hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700">
                                            Atualizar
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">{{ $stage->start_date?->format('d/m/Y') ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">{{ $stage->expected_date?->format('d/m/Y') ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">{{ $stage->finished_date?->format('d/m/Y') ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">{{ $stage->responsible ?: '-' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('works.stages.edit', [$work, $stage]) }}" class="action-icon action-icon--edit" title="Editar etapa" aria-label="Editar etapa">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487a2.1 2.1 0 1 1 2.97 2.97L8.25 19.04 4 20l.96-4.25 11.902-11.263Z" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('works.stages.destroy', [$work, $stage]) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta etapa?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="action-icon action-icon--delete" title="Excluir etapa" aria-label="Excluir etapa">
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
                                <td colspan="7" class="px-6 py-10 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                    Nenhuma etapa cadastrada ainda. Use o botao "Adicionar Etapa" para iniciar o cronograma desta obra.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    <tfoot class="bg-zinc-50/80 dark:bg-zinc-900/60">
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-sm font-semibold text-zinc-700 dark:text-zinc-200">Resumo do cronograma</td>
                            <td colspan="3" class="px-6 py-4 text-right text-sm text-zinc-600 dark:text-zinc-300">{{ $progress['percentage'] }}% concluido | {{ number_format($progress['completed'], 0, ',', '.') }} de {{ number_format($progress['total'], 0, ',', '.') }} etapas finalizadas</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="border-t border-zinc-100 px-6 py-4 dark:border-zinc-800">
                {{ $stages->links() }}
            </div>
        </div>
    </div>
</x-layouts::app>
