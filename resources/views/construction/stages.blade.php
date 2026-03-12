<x-layouts::app :title="__('Andamento da Obra')">
    <div class="p-6 space-y-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Andamento da Obra</h1>
                <p class="page-subtitle">Acesse rapidamente o cronograma dos empreendimentos e acompanhe a evolucao das etapas em um unico lugar.</p>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="report-stat-card">
                <p class="report-stat-card__label">Etapas totais</p>
                <p class="report-stat-card__value">{{ number_format($stats['total_stages'], 0, ',', '.') }}</p>
                <p class="report-stat-card__meta">Todas as etapas cadastradas nos empreendimentos.</p>
            </div>

            <div class="report-stat-card report-stat-card--success">
                <p class="report-stat-card__label">Concluidas</p>
                <p class="report-stat-card__value">{{ number_format($stats['completed_stages'], 0, ',', '.') }}</p>
                <p class="report-stat-card__meta">Etapas ja finalizadas e contabilizadas.</p>
            </div>

            <div class="report-stat-card report-stat-card--info">
                <p class="report-stat-card__label">Em andamento</p>
                <p class="report-stat-card__value">{{ number_format($stats['in_progress_stages'], 0, ',', '.') }}</p>
                <p class="report-stat-card__meta">Frentes de obra com execucao ativa.</p>
            </div>

            <div class="report-stat-card report-stat-card--warning">
                <p class="report-stat-card__label">Empreendimentos</p>
                <p class="report-stat-card__value">{{ number_format($stats['developments_with_stages'], 0, ',', '.') }}</p>
                <p class="report-stat-card__meta">Empreendimentos com cronograma iniciado.</p>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($developments as $development)
                @php
                    $progress = $development->stages_count > 0
                        ? (int) round(($development->completed_stages_count / $development->stages_count) * 100)
                        : 0;
                @endphp

                <article class="report-link-card">
                    <p class="report-stat-card__label">Empreendimento</p>
                    <h2 class="mt-2 text-lg font-semibold text-zinc-900 dark:text-white">{{ $development->name }}</h2>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ $development->location ?: 'Localizacao nao informada' }}</p>

                    <div class="mt-5 h-3 overflow-hidden rounded-full bg-zinc-200 dark:bg-zinc-800">
                        <div class="h-full rounded-full bg-blue-600" style="width: {{ $progress }}%"></div>
                    </div>

                    <div class="mt-4 flex items-center justify-between text-sm text-zinc-500 dark:text-zinc-400">
                        <span>{{ $progress }}% concluido</span>
                        <span>{{ number_format($development->stages_count, 0, ',', '.') }} etapas</span>
                    </div>

                    <div class="mt-5 grid gap-2 text-sm text-zinc-600 dark:text-zinc-300">
                        <div class="flex items-center justify-between">
                            <span>Concluidas</span>
                            <span>{{ number_format($development->completed_stages_count, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>Em andamento</span>
                            <span>{{ number_format($development->in_progress_stages_count, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <a href="{{ route('developments.show', $development) }}" class="ghost-button flex-1">Abrir hub</a>
                        <a href="{{ route('developments.stages.index', $development) }}" class="primary-button flex-1">Ver cronograma</a>
                    </div>
                </article>
            @empty
                <div class="rounded-3xl border border-dashed border-zinc-300 bg-white px-6 py-12 text-center text-sm text-zinc-500 shadow-sm md:col-span-2 xl:col-span-3 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-400 dark:shadow-none">
                    Nenhum empreendimento com etapas cadastradas ainda.
                </div>
            @endforelse
        </div>

        <div class="table-card">
            <div class="border-t border-zinc-100 px-6 py-4 dark:border-zinc-800">
                {{ $developments->links() }}
            </div>
        </div>
    </div>
</x-layouts::app>