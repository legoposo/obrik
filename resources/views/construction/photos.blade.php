<x-layouts::app :title="__('Fotos da Obra')">
    <div class="p-6 space-y-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Fotos da Obra</h1>
                <p class="page-subtitle">Visualize rapidamente os empreendimentos com galeria ativa e acompanhe os registros visuais mais recentes das obras.</p>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div class="report-stat-card report-stat-card--info">
                <p class="report-stat-card__label">Fotos cadastradas</p>
                <p class="report-stat-card__value">{{ number_format($stats['total_photos'], 0, ',', '.') }}</p>
                <p class="report-stat-card__meta">Registros visuais armazenados na plataforma.</p>
            </div>

            <div class="report-stat-card">
                <p class="report-stat-card__label">Empreendimentos com galeria</p>
                <p class="report-stat-card__value">{{ number_format($stats['developments_with_photos'], 0, ',', '.') }}</p>
                <p class="report-stat-card__meta">Empreendimentos com historico fotografico ativo.</p>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card__body space-y-5">
                <div>
                    <p class="panel-card__eyebrow">Recentes</p>
                    <h2 class="panel-card__title">Ultimas fotos publicadas</h2>
                </div>

                <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                    @forelse ($recentPhotos as $photo)
                        <article class="overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                            <div class="aspect-[4/3] bg-zinc-100 dark:bg-zinc-800">
                                <img src="{{ asset('storage/'.$photo->image_path) }}" alt="{{ $photo->title }}" class="h-full w-full object-cover">
                            </div>
                            <div class="p-4">
                                <p class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $photo->title }}</p>
                                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">{{ $photo->development->name ?? '-' }} | {{ $photo->date?->format('d/m/Y') ?? '-' }}</p>
                                @if ($photo->description)
                                    <p class="mt-3 text-sm leading-6 text-zinc-600 dark:text-zinc-300">{{ \Illuminate\Support\Str::limit($photo->description, 100) }}</p>
                                @endif
                            </div>
                        </article>
                    @empty
                        <div class="rounded-2xl border border-dashed border-zinc-300 px-5 py-8 text-sm text-zinc-500 dark:border-zinc-700 dark:text-zinc-400 md:col-span-2 xl:col-span-3">
                            Nenhuma foto cadastrada ate o momento.
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
                    <p class="mt-4 text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ number_format($development->photos_count, 0, ',', '.') }}</p>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">Fotos registradas para este empreendimento.</p>

                    <div class="mt-6 flex gap-3">
                        <a href="{{ route('developments.show', $development) }}" class="ghost-button flex-1">Abrir hub</a>
                        <a href="{{ route('developments.photos.index', $development) }}" class="primary-button flex-1">Ver galeria</a>
                    </div>
                </article>
            @empty
                <div class="rounded-3xl border border-dashed border-zinc-300 bg-white px-6 py-12 text-center text-sm text-zinc-500 shadow-sm md:col-span-2 xl:col-span-3 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-400 dark:shadow-none">
                    Nenhum empreendimento encontrado para exibir a galeria.
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