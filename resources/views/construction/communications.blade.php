<x-layouts::app :title="__('Comunicados')">
    <div class="p-6 space-y-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Comunicados</h1>
                <p class="page-subtitle">Centralize a comunicacao dos empreendimentos e acesse rapidamente o historico de avisos, documentos e atualizacoes de obra.</p>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div class="report-stat-card report-stat-card--info">
                <p class="report-stat-card__label">Comunicados publicados</p>
                <p class="report-stat-card__value">{{ number_format($stats['total_communications'], 0, ',', '.') }}</p>
                <p class="report-stat-card__meta">Mensagens ja registradas no sistema.</p>
            </div>

            <div class="report-stat-card">
                <p class="report-stat-card__label">Empreendimentos ativos</p>
                <p class="report-stat-card__value">{{ number_format($stats['developments_with_communications'], 0, ',', '.') }}</p>
                <p class="report-stat-card__meta">Empreendimentos com historico de comunicacao.</p>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card__body space-y-5">
                <div>
                    <p class="panel-card__eyebrow">Recentes</p>
                    <h2 class="panel-card__title">Ultimos comunicados</h2>
                </div>

                <div class="space-y-3">
                    @forelse ($recentCommunications as $communication)
                        <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-800/60">
                            <div class="flex flex-wrap items-start justify-between gap-3">
                                <div>
                                    <p class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $communication->title }}</p>
                                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ $communication->development->name ?? '-' }}</p>
                                </div>
                                <span class="text-xs text-zinc-500 dark:text-zinc-400">{{ $communication->created_at?->format('d/m/Y H:i') ?? '-' }}</span>
                            </div>
                            <p class="mt-3 text-sm leading-6 text-zinc-600 dark:text-zinc-300">{{ \Illuminate\Support\Str::limit($communication->message, 140) }}</p>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-dashed border-zinc-300 px-5 py-8 text-sm text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">
                            Nenhum comunicado publicado ate o momento.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($developments as $development)
                <article class="report-link-card">
                    <p class="report-stat-card__label">Empreendimento</p>
                    <h2 class="mt-2 text-lg font-semibold text-zinc-900 dark:text-white">{{ $development->name }}</h2>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ $development->location ?: 'Localizacao nao informada' }}</p>
                    <p class="mt-4 text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ number_format($development->communications_count, 0, ',', '.') }}</p>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">Comunicados cadastrados para este empreendimento.</p>

                    <div class="mt-6 flex gap-3">
                        <a href="{{ route('developments.show', $development) }}" class="ghost-button flex-1">Abrir hub</a>
                        <a href="{{ route('developments.communications.index', $development) }}" class="primary-button flex-1">Ver comunicados</a>
                    </div>
                </article>
            @empty
                <div class="rounded-3xl border border-dashed border-zinc-300 bg-white px-6 py-12 text-center text-sm text-zinc-500 shadow-sm md:col-span-2 xl:col-span-3 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-400 dark:shadow-none">
                    Nenhum empreendimento encontrado para exibir comunicados.
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