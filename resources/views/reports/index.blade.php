<x-layouts::app :title="__('Relatorios')">
    @php
        $accentMap = [
            'blue' => 'bg-blue-50 text-blue-700 ring-blue-100 dark:bg-blue-950/40 dark:text-blue-300 dark:ring-blue-900/60',
            'emerald' => 'bg-emerald-50 text-emerald-700 ring-emerald-100 dark:bg-emerald-950/40 dark:text-emerald-300 dark:ring-emerald-900/60',
            'amber' => 'bg-amber-50 text-amber-700 ring-amber-100 dark:bg-amber-950/40 dark:text-amber-300 dark:ring-amber-900/60',
            'violet' => 'bg-violet-50 text-violet-700 ring-violet-100 dark:bg-violet-950/40 dark:text-violet-300 dark:ring-violet-900/60',
        ];
    @endphp

    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Relatorios</h1>
                <p class="page-subtitle">Centralize a leitura operacional da construtora com relatorios claros, filtraveis e prontos para consulta diaria.</p>
            </div>
        </div>

        @include('reports.partials.nav')

        <div class="panel-card mb-6">
            <div class="panel-card__body">
                <div class="panel-card__intro mb-0">
                    <p class="panel-card__eyebrow">Area analitica</p>
                    <h2 class="panel-card__title">Escolha um relatorio para explorar</h2>
                    <p class="panel-card__text">Cada bloco leva a uma visao dedicada com filtros no topo, tabela paginada e totais consolidados no rodape.</p>
                </div>
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($cards as $card)
                <div class="report-link-card">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $accentMap[$card['accent']] ?? $accentMap['blue'] }}">
                                {{ number_format($card['metric'], 0, ',', '.') }}
                            </span>
                            <h2 class="mt-4 text-lg font-semibold text-zinc-900 dark:text-white">{{ $card['title'] }}</h2>
                        </div>

                        <span class="rounded-2xl border border-zinc-200 bg-zinc-50 px-3 py-2 text-xs font-semibold uppercase tracking-[0.18em] text-zinc-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-400">
                            OBRYN
                        </span>
                    </div>

                    <p class="mt-4 text-sm leading-6 text-zinc-500 dark:text-zinc-400">{{ $card['description'] }}</p>

                    <div class="mt-6 flex items-center justify-between gap-4 border-t border-zinc-100 pt-5 dark:border-zinc-800">
                        <div>
                            <p class="text-sm font-semibold text-zinc-800 dark:text-zinc-100">{{ number_format($card['metric'], 0, ',', '.') }}</p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $card['metric_label'] }}</p>
                        </div>

                        <a href="{{ $card['route'] }}" class="primary-button">
                            Abrir
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layouts::app>
